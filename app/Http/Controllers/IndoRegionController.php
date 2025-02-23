<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Regency;
use App\Models\Village;
use Illuminate\Http\Request;

class IndoRegionController extends Controller
{
    public function getKabupaten(Request $request)
    {
        $id_provinsi = $request->id_provinsi;
        $kabupatens = Regency::where('province_id', $id_provinsi)->get();

        $option = "<option>--Pilih Kabupaten--</option>";
        foreach ($kabupatens as $kabupaten) {
            $option .= "<option value='$kabupaten->id'>$kabupaten->name</option>";
        }
        echo $option;
    }

    public function getKecamatan(Request $request)
    {
        $id_kabupaten = $request->id_kabupaten;
        $kecamatans = District::where('regency_id', $id_kabupaten)->get();

        $option = "<option>--Pilih Kecamatan--</option>";
        foreach ($kecamatans as $kecamatan) {
            $option .= "<option value='$kecamatan->id'>$kecamatan->name</option>";
        }
        echo $option;
    }

    public function getKelurahan(Request $request)
    {
        $id_kecamatan = $request->id_kecamatan;
        $kelurahans = Village::where('district_id', $id_kecamatan)->get();

        $option = "<option>--Pilih Kelurahan--</option>";

        foreach ($kelurahans as $kelurahan) {
            $option .= "<option value='$kelurahan->id'>$kelurahan->name</option>";
        }
        echo $option;
    }
}
