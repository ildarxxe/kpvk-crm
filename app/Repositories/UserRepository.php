<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function findByPhone(string $phone)
    {
        return User::query()->where('phone', $phone)->first();
    }

    public function create(array $data)
    {
        return User::query()->create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'role_id' => 1,
        ]);
    }
}
