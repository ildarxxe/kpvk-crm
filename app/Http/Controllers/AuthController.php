<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

Class AuthController extends Controller {
    public function showLogin(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $attemptCredentials = (env('APP_MODE', 'production') === 'dev')
            ? ['email' => $credentials['email'], 'password' => $credentials['password']]
            : ['userprincipalname' => $credentials['email'], 'password' => $credentials['password']];

        if (Auth::attempt($attemptCredentials)) {
            $request->session()->regenerate();
            return redirect('/');
        }

        return back()->withErrors(['email' => 'Неверные данные']);
    }

    public function logout(Request $request): RedirectResponse
    {
        if ($request->user()) {
            $request->user()->currentAccessToken()?->delete();
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
