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

    public function showRegister(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $request->merge([
            'phone' => str_replace(' ', '', $request->phone)
        ]);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required|string|min:8',
            'cabinet_number' => 'nullable|integer',
        ]);

        if (empty($request->cabinet_number)) {
            return back()->withErrors(['cabinet_number' => 'Для учителя обязательно указание кабинета']);
        }

        $user = User::query()->create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            "cabinet_number" => $validated['cabinet_number'],
            'role_id' => 1,
        ]);

        auth()->loginUsingId($user->id);

        return redirect()->route('dashboard');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['userprincipalname' => $credentials['email'], 'password' => $credentials['password']])) {
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
