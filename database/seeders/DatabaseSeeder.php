<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\Staff;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create the Default Admin User
        User::factory()->create([
            'name' => 'Security Admin',
            'email' => 'admin@paau.edu.ng',
            'password' => Hash::make('password123'), // Your login password
        ]);

        // 2. Generate Mock Data
        Student::factory(150)->create();
        Staff::factory(50)->create();
    }
}