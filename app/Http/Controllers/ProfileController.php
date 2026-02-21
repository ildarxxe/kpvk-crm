<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function viewProfile(): Factory|View
    {
        $user = auth()->user();
        return view('profile')->with('user', $user);
    }

    public function viewUserProfile($user_id): Factory|View
    {
        $user = User::query()->findOrFail($user_id);
        return view('profile')->with('user', $user);
    }

    public function changePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            "password" => "required|string|min:8",
            "new_password" => "required|string|min:8",
        ]);

        $user = auth()->user();
        if(Hash::check($validated['password'], $user->password)) {
            $user->password = Hash::make($validated['new_password']);
            $user->save();
            return redirect()->back()->with("success", "Пароль успешно изменен");
        }
        return redirect()->back()->withErrors(['password' => "Неверный пароль"]);
    }
    
    public function viewCompleteProfile(): Factory|View
    {
        return view('profile.complete', ['user' => auth()->user()]);
    }

    public function completeProfile(Request $request): RedirectResponse
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:users,phone,' . $user->id,
            'cabinet_number' => 'nullable|integer',
        ]);

        $user->update($validated);

        return redirect()->route('profile')->with('success', 'Профиль успешно обновлен');
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:users,phone,' . $user->id,
            'cabinet_number' => 'nullable|integer',
        ]);

        $user->update($validated);

        return redirect()->back()->with('success', 'Данные профиля обновлены');
    }
}
