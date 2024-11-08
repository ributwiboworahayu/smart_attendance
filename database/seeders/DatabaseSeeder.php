<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Religion;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::factory()->create([
            'name' => 'SuperAdmin',
            'email' => 'superadmin@mail.com'
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'superadmin.pamela@gmail.com'
        ]);

        User::factory()->create([
            'name' => 'Ribut',
            'email' => 'rahayu@mail.com'
        ]);

        Role::create([
            'name' => 'SuperAdmin',
            'key' => 'superadmin',
            'description' => 'Super Admin Role'
        ]);

        Role::create([
            'name' => 'Admin',
            'key' => 'admin',
            'description' => 'Admin Role'
        ]);

        Role::create([
            'name' => 'User',
            'key' => 'user',
            'description' => 'User Role'
        ]);

        UserRole::create([
            'user_id' => 1,
            'role_id' => 1
        ]);

        UserRole::create([
            'user_id' => 2,
            'role_id' => 2 // is Admin role for login web
        ]);

        UserRole::create([
            'user_id' => 3,
            'role_id' => 3 // is User role for login with api
        ]);

        $religion = [
            'Islam',
            'Kristen',
            'Katolik',
            'Hindu',
            'Budha',
            'Konghucu'
        ];

        foreach ($religion as $value) {
            Religion::create([
                'name' => $value,
                'description' => 'Ini adalah agama ' . $value
            ]);
        }
    }
}
