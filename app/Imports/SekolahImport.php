<?php

namespace App\Imports;

use App\Models\Sekolah;
use App\Jobs\AmbilKoordinatSekolahJob;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SekolahImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // ini_set('max_execution_time', 300);
        
        set_time_limit(0); // Tidak dibatasi waktu eksekusi

        $existingSekolah = Sekolah::where('id', $row['nama_sekolah'])->first();
        if ($existingSekolah) {
            return null;
        }

        $sekolah = Sekolah::create([
            'id' => $row['nama_sekolah'],
            'nama_sekolah' => $row['nama_sekolah'],
            'jenis' => $row['jenis'],
            'status' => $row['status'],
            'provinsi' => null,
            'kabupaten' => null,
            'kecamatan' => null,
            'kelurahan' => null,
            'koordinat' => null,
        ]);

        // Dispatch Job untuk ambil koordinat dan alamat
        AmbilKoordinatSekolahJob::dispatch($sekolah);

        return $sekolah;
    }
}
