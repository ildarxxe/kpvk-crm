<?php

namespace Database\Seeders;

use App\Models\TaskPriority;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $roles = ['teacher', 'deputy', 'admin'];
        foreach ($roles as $role) {
            UserRole::query()->firstOrCreate(['role' => $role]);
        }

        $priorities = ['low', 'medium', 'high'];
        foreach ($priorities as $name) {
            TaskPriority::query()->firstOrCreate(['name' => $name]);
        }
    }
}
