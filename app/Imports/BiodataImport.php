<?php

namespace App\Imports;

use App\Models\Biodata;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Jobs\GeocodeBiodata;

class BiodataImport implements ToModel,WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $existingBiodata = Biodata::where('id_biodata', $row['nim'])->first();
        $existingUser = User::where('nim', $row['nim'])->first();
        
        if ($existingUser && $existingBiodata) {
            return null;
        } else if ($existingBiodata) {
            return null;
        }
// dd($row);
        return new Biodata([
            'id_biodata' => $row['nim'],
            'nim' => $row['nim'],
            'kode_mhs' => $row['kode_mhs'],
            'nama' => $row['nama'],
            'status' => $row['status'],
            'telepon' => $row['telepon'],
            'angkatan' => $row['angkatan'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'agama' => $row['agama'],
            'tempat_lahir' => $row['tempat_lahir'],
            'alamat' => $row['alamat'],
            'provinsi' => $row['provinsi'],
            'kabupaten' => $row['kabupaten'],
            'kecamatan' => $row['kecamatan'],
            'kelurahan' => $row['kelurahan'],
            // 'koordinat' => $row['koordinat'],
            'penghasilan' => $row['penghasilan'],
            'id_sekolah' => $row['id_sekolah'],
            'id_tempat_tinggal' => $row['id_tempat_tinggal'],
            'tanggal_lahir' => $row['tanggal_lahir'],
        ]);

        
        // Simpan terlebih dahulu ke database
        // $biodata->save();
        // dd($biodata);
        
      
        // Kirim job geocoding (delay 1 detik untuk hindari rate limit)
        GeocodeBiodata::dispatch($biodata->id_biodata)->delay(now()->addSeconds(1));
 
        // return $biodata;
    }
}