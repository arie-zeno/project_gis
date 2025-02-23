<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        User::create([
            'nim' => '1',
            'name' => 'Admin GIS',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Mahasiswa User
        User::create([
            'nim' => '2110131310002',
            'name' => 'Mahasiswa GIS',
            'email' => 'mahasiswa@example.com',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
        ]);

        User::create([
            'nim' => '2110131310001',
            'name' => 'Alfika',
            'email' => '2110131310001@mhs.ulm.ac.id',
            'password' => Hash::make('123'),
            'role' => 'mahasiswa',
        ]);

    }
}
