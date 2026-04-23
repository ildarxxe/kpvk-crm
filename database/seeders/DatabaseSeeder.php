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

        if (env('APP_MODE', 'production') === 'dev') {
            $teacherRoleId = UserRole::query()->where('role', 'teacher')->value('id');
            $deputyRoleId = UserRole::query()->where('role', 'deputy')->value('id');
            $adminRoleId = UserRole::query()->where('role', 'admin')->value('id');

            User::query()->firstOrCreate(
                ['email' => 'teacher@local.test'],
                ['name' => 'Teacher', 'password' => Hash::make('password'), 'role_id' => $teacherRoleId]
            );

            User::query()->firstOrCreate(
                ['email' => 'deputy@local.test'],
                ['name' => 'Deputy', 'password' => Hash::make('password'), 'role_id' => $deputyRoleId]
            );

            User::query()->firstOrCreate(
                ['email' => 'admin@local.test'],
                ['name' => 'Admin', 'password' => Hash::make('password'), 'role_id' => $adminRoleId]
            );
        }
    }
}
