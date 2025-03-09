<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempatTinggal extends Model
{
    use HasFactory;

    protected $table = "tempat_tinggal";
    protected $fillable = [
        "id",
        "koordinat",
        'provinsi',
        'kabupaten',
        'kecamatan',
        'kelurahan',
    ];
    public function biodata(){
        return $this->hasOne(Biodata::class, "id_tempat_tinggal");
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
