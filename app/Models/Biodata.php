<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biodata extends Model
{
    use HasFactory;
    protected $primaryKey = "id_biodata";
    protected $table = "Biodata";

    protected $fillable = [
        'id_biodata',
        'nim',
        'nama',
        'telepon',
        'angkatan',
        'jenis_kelamin',
        'agama',
        'foto',
        'tempat_lahir',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'kelurahan',
        'koordinat',
        'penghasilan',
        'id_sekolah',
        'id_tempat_tinggal',
        'tanggal_lahir',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "nim");
    }

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function tempat_tinggal()
    {
        return $this->belongsTo(Tempat_Tinggal::class);
    }

    public function provinsi(){
        return $this->belongsTo(Province::class,"provinsi", "name");
    }
}
