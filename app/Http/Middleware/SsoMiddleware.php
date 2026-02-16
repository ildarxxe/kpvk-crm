<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use LdapRecord\Laravel\Import\UserSynchronizer;
use LdapRecord\Models\Model as LdapRecordModel;
use Symfony\Component\HttpFoundation\Response;

class SsoMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            return $next($request);
        }

        $remoteUser = $request->server('REMOTE_USER');
        if (! $remoteUser) {
            return $next($request);
        }

        try {
            $username = $this->parseUsername($remoteUser);

            if (! $username) {
                return $next($request);
            }

            $ldapModelClass = Config::get('auth.providers.users.model');

            if (! $ldapModelClass || ! class_exists($ldapModelClass)) {
                Log::error("SSO Middleware: LDAP model class not found: $ldapModelClass");
                return $next($request);
            }

            $ldapUser = $this->findLdapUser($ldapModelClass, $username);

            if (! $ldapUser) {
                Log::info("SSO Middleware: User not found in LDAP: $username (Remote: $remoteUser)");
                return $next($request);
            }

            $eloquentModelClass = Config::get('auth.providers.users.database');

            $providerConfig = Config::get('auth.providers.users', []);

            $synchronizer = new UserSynchronizer($eloquentModelClass, $providerConfig);

            $eloquentUser = $synchronizer->run($ldapUser, [
                'password' => Str::random(64),
            ]);
            Auth::login($eloquentUser);
            Log::info("SSO Middleware: Automatically logged in user: {$eloquentUser->name} ({$username})");
        } catch (\Exception $e) {
            Log::error('SSO Middleware Error: ' . $e->getMessage());
        }
        return $next($request);
    }

    protected function parseUsername(string $remoteUser): ?string
    {
        if (strpos($remoteUser, '\\') !== false) {
            $parts = explode('\\', $remoteUser);
            return end($parts);
        }
        if (strpos($remoteUser, '@') !== false) {
            $parts = explode('@', $remoteUser);
            return reset($parts);
        }
        return $remoteUser;
    }

    protected function findLdapUser(string $modelClass, string $username): ?LdapRecordModel
    {
        $query = new $modelClass;
        return $query->where('samaccountname', '=', $username)
            ->orWhere('uid', '=', $username)
            ->first();
    }
}
