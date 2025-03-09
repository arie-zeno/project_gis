<?php

namespace App\Exports;

use App\Models\Biodata;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BiodataExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Biodata::select("nama", "nim", "telepon", "angkatan", "jenis_kelamin", "agama", "tempat_lahir", "provinsi", "kabupaten", "kecamatan", "kelurahan", "koordinat", "penghasilan", "id_sekolah", "id_tempat_tinggal", "tanggal_lahir")->get();
    }

    public function headings(): array
    {
        return ["Nama", "NIM", "Telepon", "Angkatan", "Jenis Kelamin", "Agama", "Tempat Lahir", "Provinsi", "Kabupaten", "Kecamatan", "Kelurahan", "koordinat", "penghasilan", "ID Sekolah", "ID Tempat Tinggal", "Tanggal Lahir"];
    }
}
