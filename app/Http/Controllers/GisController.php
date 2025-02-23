<?php

namespace App\Http\Controllers;

use App\Models\Biodata;
use App\Models\Province;
use Illuminate\Http\Request;

class GisController extends Controller
{
    public function tempatTinggal()
    {
        $provinsi = Province::with("mahasiswa")->where("name", "KALIMANTAN SELATAN")->get();
        $biodata = Biodata::all();
        return view(
            "GIS.tempat",
            [
                "provinsi" => $provinsi,
                "biodata" => $biodata,
                "title" => "GIS | Mahasiswa"
            ]
        );
    }
}
