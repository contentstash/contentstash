<?php

namespace Database\Seeders;

use App\Models\User;
use ContentStash\Core\Enums\UserRole;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin@example.com'),
        ]);
        $admin->assignRole(UserRole::ADMIN);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('test@example.com'),
        ]);

        User::factory(10)->create();
    }
}
