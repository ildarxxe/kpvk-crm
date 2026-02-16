<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckProfileMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        \Log::info('Middleware check', [
        'url' => $request->fullUrl(),
        'is_authed' => auth()->check(),
        'user_id' => auth()->id(),
        'session_id' => session()->getId(),
    ]);
        if (auth()->check() && empty(auth()->user()->phone) && empty(auth()->user()->cabinet_number) && !$request->is('complete-profile*')) {
            return redirect()->route('complete-profile')
                ->with('warning', 'Пожалуйста, заполните ваш профиль перед продолжением.');
        }

        return $next($request);
    }
}
