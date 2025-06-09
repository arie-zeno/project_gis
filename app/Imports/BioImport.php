<?php

namespace App\Imports;

use App\Models\Biodata;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BioImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);

        return new Biodata([
            'id_biodata' =>  $row['nim'],
            'nim' =>  $row['nim'],
            'kode_mhs' =>  $row['kode_mhs'],
            'nama' =>  $row['nama'],
            'status' =>  $row['status'],
            'telepon' =>  $row['telepon'],
            'angkatan' =>  $row['angkatan'],
            'jenis_kelamin' =>  $row['jenis_kelamin'],
            'agama' =>  $row['agama'],
            'tempat_lahir' =>  $row['tempat_lahir'],
            'alamat' =>  $row['alamat'],
            'provinsi' =>  $row['provinsi'],
            'kabupaten' =>  $row['kabupaten'],
            'kecamatan' =>  $row['kecamatan'],
            'kelurahan' =>  $row['kelurahan'],
            'penghasilan' =>  $row['penghasilan'],
            'id_sekolah' =>  $row['id_sekolah'],
        ]);
    }
}
