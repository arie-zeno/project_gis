<?php

namespace App\Http\Controllers;

use App\Models\Biodata;
use App\Models\Province;
use App\Models\Sekolah;
use App\Models\TempatTinggal;
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

    public function sekolah()
    {
        $provinsi = Province::with("mahasiswa")->where("name", "KALIMANTAN SELATAN")->get();
        $biodata = Sekolah::all();
        return view(
            "GIS.sekolah",
            [
                "provinsi" => $provinsi,
                "biodata" => $biodata,
                "title" => "GIS | Sekolah"
            ]
        );
    }

    public function domisili()
    {
        $provinsi = Province::with("mahasiswa")->where("name", "KALIMANTAN SELATAN")->get();
        $biodata = TempatTinggal::with("biodata")->get();
        return view(
            "GIS.domisili",
            [
                "provinsi" => $provinsi,
                "biodata" => $biodata,
                "title" => "GIS | Domisili"
            ]
        );
    }
}
