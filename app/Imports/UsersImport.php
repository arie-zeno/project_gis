<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        ini_set('max_execution_time', 240);
        $existingUser = User::where('nim', $row['nim'])->first();
        if ($existingUser) {
            return null;
        }
        return new User([
            'nim' => $row['nim'], 
            'name' => $row['name'], 
            'email' => $row['nim'] . '@mhs.ulm.ac.id',
            'password' => Hash::make($row['nim']), 
            'role' => 'mahasiswa', 
        ]);
    }
}
