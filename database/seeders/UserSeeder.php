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
        User::updateOrCreate(
            [
                'nim' => '1'
            ],
            [
                'name' => 'Admin GIS',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin'),
                'role' => 'admin',
            ]
        );

        // Mahasiswa User
        User::updateOrCreate(
            [
                'nim' => '2110131220016',
            ],
            [
                'name' => 'Alfika Nurfadia',
                'email' => '2110131220016@mhs.ulm.ac.id',
                'password' => Hash::make('123'),
                'role' => 'mahasiswa',
            ]
        );

        User::updateOrCreate(
            [
                'nim' => '2110131120005',
            ],
            [
                'name' => 'Julita Hasanah',
                'email' => '2110131120005@mhs.ulm.ac.id',
                'password' => Hash::make('123'),
                'role' => 'mahasiswa',
            ]
        );

        User::updateOrCreate(
            [
                'nim' => '2110131120006',
            ],
            [
                'name' => 'Maysarah',
                'email' => '2110131120006@mhs.ulm.ac.id',
                'password' => Hash::make('123'),
                'role' => 'mahasiswa',
            ]
        );

        
        User::updateOrCreate(
            [
                'nim' => '2110131310001',
            ],
            [
                'name' => 'Ari Yono',
                'email' => '2110131310001@@mhs.ulm.ac.id',
                'password' => Hash::make('123'),
                'role' => 'mahasiswa',
            ]
        );
    }
}
