<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biodata extends Model
{
    use HasFactory;
    protected $primaryKey = "id_biodata";
    protected $table = "Biodata";

    // Di model Biodata
    protected $casts = [
        'id_sekolah' => 'string',
    ];

    protected $fillable = [
        'id_biodata',
        'nim',
        'nama',
        'kode_mhs',
        'telepon',
        'angkatan',
        'status',
        'jenis_kelamin',
        'agama',
        'foto',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'kelurahan',
        'koordinat',
        'penghasilan',
        'id_sekolah',
        'id_tempat_tinggal',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "nim");
    }

    // public function sekolah()
    // {
    //     return $this->belongsTo(Sekolah::class, "id_sekolah");
    // }
    // public function sekolah()
    // {
    //     return $this->belongsTo(Sekolah::class, 'id_sekolah', 'id');
    // }
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah', 'id');
    }

    public function tempat_tinggal()
    {
        return $this->belongsTo(TempatTinggal::class, "id_tempat_tinggal");
    }

    public function province(){
        return $this->belongsTo(Province::class,"provinsi", "id");
    }

    public function regency(){
        return $this->belongsTo(Regency::class,"kabupaten", "id");
    }

    public function district(){
        return $this->belongsTo(District::class,"kecamatan", "id");
    }

    public function village(){
        return $this->belongsTo(Village::class,"kelurahan", "id");
    }
}
