<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Biodata;
use App\Models\Province;
use App\Models\Sekolah;
use App\Models\TempatTinggal;
use Illuminate\Http\Request;
use App\Jobs\GeocodeBiodata;

class GisController extends Controller
{
    public function home()
    {
        return view(
            "GIS.home",
            [
                "title" => "GIS | Home"
            ]
        );
    }

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

    // public function sekolah()
    // {
    //     $provinsi = Province::with("mahasiswa")->where("name", "KALIMANTAN SELATAN")->get();
    //     $biodata = Sekolah::with("biodata")->get();
    //     // @dd($biodata[0]);
    //     return view(
    //         "GIS.sekolah",
    //         [
    //             "provinsi" => $provinsi,
    //             "biodata" => $biodata,
    //             "title" => "GIS | Sekolah"
    //         ]
    //     );
    // }
    public function sekolah()
    {
        $provinsi = Province::with("mahasiswa")
            ->where("name", "KALIMANTAN SELATAN")
            ->get();

        $sekolah = Sekolah::with('biodata')->get(); // ini sudah benar

        return view("GIS.sekolah", [
            "provinsi" => $provinsi,
            "sekolah" => $sekolah, // <- GANTI DARI "biodata" KE "sekolah"
            "title" => "GIS | Sekolah"
        ]);
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

    public function statistik()
    {
        $biodata = Biodata::all();
        $biodata_kab = [
            "Kab. Balangan" => 0,
            "Kab. Banjar" => 0,
            "Kab. Barito Kuala" => 0,
            "Kab. Hulu Sungai Selatan" => 0,
            "Kab. Hulu Sungai Tengah" => 0,
            "Kab. Hulu Sungai Utara" => 0,
            "Kab. Kotabaru" => 0,
            "Kab. Tabalong" => 0,
            "Kab. Tanah Bumbu" => 0,
            "Kab. Tanah Laut" => 0,
            "Kab. Tapin" => 0,
            "Kota Banjarbaru" => 0,
            "Kota Banjarmasin" => 0,
        ];

        foreach($biodata as $data){
            if($data["kabupaten"] == "TANAH LAUT"){
                $biodata_kab["Kab. Tanah Laut"]+=1;
            } else if($data["kabupaten"] == "KOTABARU"){
                $biodata_kab["Kab. Kotabaru"]+=1;
            } else if($data["kabupaten"] == "BANJAR"){
                $biodata_kab["Kab. Banjar"]+=1;
            } else if($data["kabupaten"] == "BARITO KUALA"){
                $biodata_kab["Kab. Barito Kuala"]+=1;
            } else if($data["kabupaten"] == "TAPIN"){
                $biodata_kab["Kab. Tapin"]+=1;
            } else if($data["kabupaten"] == "HULU SUNGAI SELATAN"){
                $biodata_kab["Kab. Hulu Sungai Selatan"]+=1;
            } else if($data["kabupaten"] == "HULU SUNGAI TENGAH"){
                $biodata_kab["Kab. Hulu Sungai Tengah"]+=1;
            } else if($data["kabupaten"] == "HULU SUNGAI UTARA"){
                $biodata_kab["Kab. Hulu Sungai Utara"]+=1;
            } else if($data["kabupaten"] == "TABALONG"){
                $biodata_kab["Kab. Tabalong"]+=1;
            } else if($data["kabupaten"] == "TANAH BUMBU"){
                $biodata_kab["Kab. Tanah Bumbu"]+=1;
            } else if($data["kabupaten"] == "BALANGAN"){
                $biodata_kab["Kab. Balangan"]+=1;
            } else if($data["kabupaten"] == "BANJARBARU"){
                $biodata_kab["Kota Banjarbaru"]+=1;
            } else if($data["kabupaten"] == "BANJARMASIN"){
                $biodata_kab["Kota Banjarmasin"]+=1;
            };
                
        }

        $mhs = User::all();
        $mhs_akt = [
            "2014" => 0,
            "2015" => 0,
            "2016" => 0,
            "2017" => 0,
            "2018" => 0,
            "2019" => 0,
            "2020" => 0,
            "2021" => 0,
            "2022" => 0,
            "2023" => 0,
            "2024" => 0,
        ];
        foreach($mhs as $data){
            if($data['role'] != 'admin') {
                $angkatan = str_split($data['nim'], 2);
                $angkatan2 = str_split($data['nim'], 6);
                $angkatan = $angkatan[0];
                $angkatan2 = $angkatan2[0];
                
                if($angkatan2 == "A1C614"){
                    $mhs_akt['2014']+=1;
                } else if($angkatan2 == "A1C615"){
                    $mhs_akt['2015']+=1;
                }else if($angkatan == 16){
                    $mhs_akt['2016']+=1;
                }else if($angkatan == 17){
                    $mhs_akt['2017']+=1;
                }else if($angkatan == 18){
                    $mhs_akt['2018']+=1;
                }else if($angkatan == 19){
                    $mhs_akt['2019']+=1;
                }else if($angkatan == 20){
                    $mhs_akt['2020']+=1;
                }else if($angkatan == 21){
                    $mhs_akt['2021']+=1;
                }else if($angkatan == 22){
                    $mhs_akt['2022']+=1;
                }else if($angkatan == 23){
                    $mhs_akt['2023']+=1;
                }else if($angkatan == 24){
                    $mhs_akt['2024']+=1;
                }   
            }  
        }

        $status_mhs = [
            "Aktif" => 0,
            "Lulus" => 0,
        ];
        foreach($biodata as $data){
            if($data["status"] == "Aktif"){
                $status_mhs["Aktif"]+=1;
            } else if($data["status"] == "Lulus"){
                $status_mhs["Lulus"]+=1;
            }
        } 

        return view(
            "GIS.statistik",
            [
                "title" => "GIS | Statistik",
                "mhs_akt" => $mhs_akt,
                "biodata_kab" => $biodata_kab,
                "status_mhs" => $status_mhs,
            ]
            );
    }

    public function nominatim()
    {
        return view(
            "GIS.nominatim",
            [
                "title" => "GIS | Nominatim"
            ]
        );
    }
}
