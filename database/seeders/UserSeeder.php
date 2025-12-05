<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa tất cả users hiện có (bao gồm cả soft deleted)
        User::withTrashed()->forceDelete();

        // Tạo Admin 1
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Phong',
                'password' => Hash::make('123456'),
                'role' => 1,
                'is_admin' => 1,
                'status' => 'active',
                'email_verified_at' => now()
            ]
        );

        // Tạo Admin 2
        User::updateOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('123456'),
                'role' => 1,
                'is_admin' => 1,
                'status' => 'active',
                'email_verified_at' => now()
            ]
        );

        // Tạo Staff
        User::updateOrCreate(
            ['email' => 'staff@test.com'],
            [
                'name' => 'Phong',
                'password' => Hash::make('123456'),
                'role' => 2,
                'is_admin' => 0,
                'status' => 'active',
                'email_verified_at' => now()
            ]
        );

        // Tạo User thường 1
        User::updateOrCreate(
            ['email' => 'user@test.com'],
            [
                'name' => 'Normal User',
                'password' => Hash::make('123456'),
                'role' => 0,
                'is_admin' => 0,
                'status' => 'active',
                'email_verified_at' => now()
            ]
        );

        // Tạo Test User 1
        User::updateOrCreate(
            ['email' => 'test1@test.com'],
            [
                'name' => 'Test User 1',
                'password' => Hash::make('123456'),
                'role' => 0,
                'is_admin' => 0,
                'status' => 'active',
                'email_verified_at' => now()
            ]
        );

        // Tạo Test User 2
        User::updateOrCreate(
            ['email' => 'test2@test.com'],
            [
                'name' => 'Test User 2',
                'password' => Hash::make('123456'),
                'role' => 0,
                'is_admin' => 0,
                'status' => 'inactive',
                'email_verified_at' => now()
            ]
        );

        // Tạo Test User 3
        User::updateOrCreate(
            ['email' => 'test3@test.com'],
            [
                'name' => 'Test User 3',
                'password' => Hash::make('123456'),
                'role' => 0,
                'is_admin' => 0,
                'status' => 'blocked',
                'email_verified_at' => now()
            ]
        );

        $this->command->info('Created test users:');
        $this->command->info('Admin 1: admin@example.com / 123456 (role=1, status=active)');
        $this->command->info('Admin 2: admin@test.com / 123456 (role=1, status=active)');
        $this->command->info('Staff: staff@test.com / 123456 (role=2, status=active)');
        $this->command->info('User 1: user@test.com / 123456 (role=0, status=active)');
        $this->command->info('User 2: test1@test.com / 123456 (role=0, status=active)');
        $this->command->info('User 3: test2@test.com / 123456 (role=0, status=inactive)');
        $this->command->info('User 4: test3@test.com / 123456 (role=0, status=blocked)');
    }
}