<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;
    protected $primaryKey = "id_sekolah";

    protected $table = "sekolah";

    public function biodata(){
        return $this->hasMany(Biodata::class);
    }

}
