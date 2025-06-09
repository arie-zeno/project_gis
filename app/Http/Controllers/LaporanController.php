<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Biodata;
use Illuminate\Support\Facades\Log;
use PDF;

class LaporanController extends Controller
{
    public function cetakLaporan()
    {
        $biodata = Biodata::with('sekolah')->get();

        // Inisialisasi array kabupaten
        $daftar_kab = [
            "Kab. Balangan", "Kab. Banjar", "Kab. Barito Kuala", "Kab. Hulu Sungai Selatan",
            "Kab. Hulu Sungai Tengah", "Kab. Hulu Sungai Utara", "Kab. Kotabaru", "Kab. Tabalong",
            "Kab. Tanah Bumbu", "Kab. Tanah Laut", "Kab. Tapin", "Kota Banjarbaru", "Kota Banjarmasin", "Lainnya"
        ];

        $biodata_kab = $aktif_kab = $lulus_kab = array_fill_keys($daftar_kab, 0);

        foreach ($biodata as $data) {
            $kab = strtoupper($data->kabupaten);
            $status = strtolower($data->status);
            $map = [
                "TANAH LAUT" => "Kab. Tanah Laut",
                "KOTABARU" => "Kab. Kotabaru",
                "BANJAR" => "Kab. Banjar",
                "BARITO KUALA" => "Kab. Barito Kuala",
                "TAPIN" => "Kab. Tapin",
                "HULU SUNGAI SELATAN" => "Kab. Hulu Sungai Selatan",
                "HULU SUNGAI TENGAH" => "Kab. Hulu Sungai Tengah",
                "HULU SUNGAI UTARA" => "Kab. Hulu Sungai Utara",
                "TABALONG" => "Kab. Tabalong",
                "TANAH BUMBU" => "Kab. Tanah Bumbu",
                "BALANGAN" => "Kab. Balangan",
                "BANJARBARU" => "Kota Banjarbaru",
                "BANJARMASIN" => "Kota Banjarmasin",
            ];

            $nama_kab = $map[$kab] ?? "Lainnya";

            $biodata_kab[$nama_kab]++;
            if ($status == "aktif") {
                $aktif_kab[$nama_kab]++;
            } else {
                $lulus_kab[$nama_kab]++;
            }
        }

        $total = $biodata->count();
        $totalAktif = array_sum($aktif_kab);
        $totalAlumni = array_sum($lulus_kab);

        $pdf = PDF::loadView('laporan.sig', compact(
            'biodata', 'biodata_kab', 'aktif_kab', 'lulus_kab',
            'total', 'totalAktif', 'totalAlumni'
        ))->setPaper('A4', 'portrait');

        return $pdf->download('laporan-persebaran-mahasiswa.pdf');
    }

}
