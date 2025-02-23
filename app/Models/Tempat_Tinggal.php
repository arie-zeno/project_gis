<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tempat_Tinggal extends Model
{
    use HasFactory;

    protected $table = "Tempat_Tinggal";

    public function biodata(){
        return $this->hasOne(Biodata::class);
    }

}
