<?php

namespace App\Imports;

use App\Models\Sekolah;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SekolahImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $existingSekolah = Sekolah::where('id', $row['id'])->first();
        if ($existingSekolah) {
            return null;
        }
        return new Sekolah([
            'id' => $row['id'], 
            'nama_sekolah' => $row['nama_sekolah'], 
            'jenis' => $row['jenis'], 
            'status' => $row['status'], 
            'provinsi' => $row['provinsi'], 
            'kabupaten' => $row['kabupaten'], 
            'kecamatan' => $row['kecamatan'], 
            'kelurahan' => $row['kelurahan'], 
            'koordinat' => $row['koordinat'], 
        ]);
    }

    // public function model(array $row)
    // {
    //     $existingUser = User::where('nim', $row['nim'])->first();
    //     if ($existingUser) {
    //         return null;
    //     }
    //     return new User([
    //         'nim' => $row['nim'], 
    //         'name' => $row['name'], 
    //         'email' => $row['nim'] . '@mhs.ulm.ac.id',
    //         'password' => Hash::make($row['nim']), 
    //         'role' => 'mahasiswa', 
    //     ]);
    // }
}
