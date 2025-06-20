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
        $angkatan_data = [];
        $status_mhs = ['Aktif' => 0, 'Lulus' => 0];

        foreach ($biodata as $data) {
            $kab = strtoupper($data->kabupaten);
            $status = strtolower($data->status);
            $angkatan = $data->angkatan;

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
            $angkatan_data[$angkatan] = ($angkatan_data[$angkatan] ?? 0) + 1;

            if ($status == "aktif") {
                $aktif_kab[$nama_kab]++;
                $status_mhs['Aktif']++;
            } else {
                $lulus_kab[$nama_kab]++;
                $status_mhs['Lulus']++;
            }
        }

        $total = $biodata->count();
        $totalAktif = array_sum($aktif_kab);
        $totalAlumni = array_sum($lulus_kab);

        // ---- 🔥 Generate CHART base64 ----
        $chartStatus = $this->generateChartBase64([
            'type' => 'pie',
            'data' => [
                'labels' => ['Aktif', 'Lulus'],
                'datasets' => [[
                    'data' => [$status_mhs['Aktif'], $status_mhs['Lulus']],
                    'backgroundColor' => ['#1cc88a', '#e74a3b'],
                ]]
            ],
            'options' => [
                'title' => ['display' => true, 'text' => 'Status Mahasiswa'],
                'plugins' => [
                    'datalabels' => [
                        'color' => '#000',
                        'font' => ['weight' => 'bold', 'size' => 14],
                        'formatter' => 'function(value, ctx) { return value; }'
                    ]
                ]
            ],
            'plugins' => ['datalabels']
        ]);

        $chartKabupaten = $this->generateChartBase64([
            'type' => 'bar',
            'data' => [
                'labels' => array_keys($biodata_kab),
                'datasets' => [[
                    'label' => 'Jumlah Mahasiswa',
                    'data' => array_values($biodata_kab),
                    'backgroundColor' => '#4e73df'
                ]]
            ],
            'options' => [
                'title' => ['display' => true, 'text' => 'Persebaran Mahasiswa per Kabupaten'],
                'scales' => ['yAxes' => [['ticks' => ['beginAtZero' => true]
                ]]],
                'plugins' => [
                    'datalabels' => [
                        'anchor' => 'end',
                        'align' => 'top',
                        'color' => '#000',
                        'font' => ['weight' => 'bold', 'size' => 12]
                    ]
                ]
            ],
            'plugins' => ['datalabels']
        ]);

        ksort($angkatan_data);
        $chartAngkatan = $this->generateChartBase64([
            'type' => 'bar',
            'data' => [
                'labels' => array_keys($angkatan_data),
                'datasets' => [[
                    'label' => 'Jumlah Mahasiswa',
                    'data' => array_values($angkatan_data),
                    'backgroundColor' => '#36b9cc'
                ]]
            ],
            'options' => [
                'title' => ['display' => true, 'text' => 'Mahasiswa per Angkatan'],
                'scales' => ['yAxes' => [['ticks' => ['beginAtZero' => true]
                ]]],
                'plugins' => [
                    'datalabels' => [
                        'anchor' => 'end',
                        'align' => 'top',
                        'color' => '#000',
                        'font' => ['weight' => 'bold', 'size' => 12]
                    ]
                ]
            ],
            'plugins' => ['datalabels']
        ]);

        $chartAktifKab = $this->generateChartBase64([
            'type' => 'bar',
            'data' => [
                'labels' => array_keys($aktif_kab),
                'datasets' => [[
                    'label' => 'Mahasiswa Aktif',
                    'data' => array_values($aktif_kab),
                    'backgroundColor' => '#1cc88a'
                ]]
            ],
            'options' => [
                'title' => ['display' => true, 'text' => 'Mahasiswa Aktif per Kabupaten'],
                'indexAxis' => 'y',
                'plugins' => [
                    'datalabels' => [
                        'anchor' => 'end',
                        'align' => 'top',
                        'color' => '#000',
                        'font' => ['weight' => 'bold', 'size' => 12],
                        'formatter' => 'function(value) { return value; }'
                    ]
                ],
                'scales' => [
                    'x' => ['beginAtZero' => true],
                ]
            ],
            'plugins' => ['datalabels']
        ]);

        $chartLulusKab = $this->generateChartBase64([
            'type' => 'bar',
            'data' => [
                'labels' => array_keys($lulus_kab),
                'datasets' => [[
                    'label' => 'Alumni',
                    'data' => array_values($lulus_kab),
                    'backgroundColor' => '#e74a3b'
                ]]
            ],
            'options' => [
                'title' => ['display' => true, 'text' => 'Alumni per Kabupaten'],
                'indexAxis' => 'y',
                'plugins' => [
                    'datalabels' => [
                        'anchor' => 'end',
                        'align' => 'top',
                        'color' => '#000',
                        'font' => ['weight' => 'bold', 'size' => 12],
                        'formatter' => 'function(value) { return value; }'
                    ]
                ],
                'scales' => [
                    'x' => ['beginAtZero' => true],
                ]
            ],
            'plugins' => ['datalabels']
        ]);


        $pdf = PDF::loadView('laporan.sig', compact(
            'biodata', 'biodata_kab', 'aktif_kab', 'lulus_kab',
            'total', 'totalAktif', 'totalAlumni',  'chartAngkatan','chartStatus', 'chartKabupaten', 'chartAktifKab', 'chartLulusKab'
        ))->setPaper('A4', 'portrait');

        return $pdf->download('laporan-persebaran-mahasiswa.pdf');
    }

    private function generateChartBase64($chartConfig)
    {
        $url = "https://quickchart.io/chart?c=" . urlencode(json_encode($chartConfig));
        $image = file_get_contents($url);
        return 'data:image/png;base64,' . base64_encode($image);
    }

}
