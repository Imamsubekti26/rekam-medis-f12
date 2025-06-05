<?php

namespace Database\Seeders;

use App\Models\Medicine;
use App\Models\Patient;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create Admin
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@moon.id',
            'is_admin' => true,
        ]);

        // Create Doctor
        User::factory()->doctor()->create([
            'name' => 'Andi',
            'email' => 'andi@moon.id',
        ]);

        // Create pharmacist
        User::factory()->pharmacist()->create([
            'name' => 'Dina',
            'email' => 'dina@moon.id',
        ]);

        // Create Patient
        Patient::factory()->create([
            'nik' => '3175091301020001',
            'name' => 'Imam',
            'is_male' => true,
        ]);

        Patient::factory()->create([
            'nik' => '3517012108990002',
            'name' => 'Subekti',
            'is_male' => true,
        ]);

        // Create Medicine
        Medicine::factory()->create([
            'name' => 'Paracetamol',
            'barcode' => '123123123',
            'price' => 3200,
        ]);
    }
}
