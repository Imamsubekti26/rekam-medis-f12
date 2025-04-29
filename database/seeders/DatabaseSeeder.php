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
            'password' => Hash::make('123123123'),
        ]);

        // Create Doctor
        User::factory()->create([
            'name' => 'Andi',
            'email' => 'andi@moon.id',
            'is_admin' => false,
            'password' => Hash::make('123123123'),
        ]);

        // Create Patient
        Patient::factory()->create([
            'member_id' => '11101',
            'name' => 'Imam',
            'is_male' => true,
        ]);

        Patient::factory()->create([
            'member_id' => '11102',
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
