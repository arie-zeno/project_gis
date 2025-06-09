<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;
    protected $primaryKey = "id";
    protected $table = "sekolah";
    public $incrementing = false; // <- penting karena id bukan angka
    protected $keyType = 'string';      // Tipe ID-nya string
    protected $fillable = [
        "id",
        "nama_sekolah",
        "jenis",
        "status",
        "koordinat",
        'provinsi',
        'kabupaten',
        'kecamatan',
        'kelurahan',
    ];
    // public function biodata()
    // {
    //     return $this->hasMany(Biodata::class, "id_sekolah");
    // }
    // public function biodata()
    // {
    //     return $this->hasMany(Biodata::class, 'id_sekolah', 'id');
    // }
    
    public function biodata()
    {
        return $this->hasMany(Biodata::class, 'id_sekolah', 'id');
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
