@extends ("GIS.layouts.app")
<style>
    .chart-row {
    display: flex;
    justify-content: center;
    gap: 2rem; /* Jarak antar chart */
    flex-wrap: wrap; /* Biar responsive di layar kecil */
    margin: 2rem;
    }

    .chart-box {
    width: 500px;
    }

    canvas {
    width: 80% !important;
    height: 300px !important;
    }

</style>

<div class="chart-row">
    <div class="chart-box">
      <h5 style="text-align: center">Jumlah Mahasiswa Per-Angkatan</h5>
      <canvas id="ChartMHS_Angkatan"></canvas>
      <p class="text-secondary" style="text-align: center">Angkatan</p>
    </div>
  
    <div class="chart-box">
      <h5 style="text-align: center">Asal Mahasiswa</h5>
      <canvas id="ChartMHS_Kab"></canvas>
      <p class="text-secondary" style="text-align: center">Kabupaten/Kota</p>
    </div>

    <div class="chart-box">
      <h5 style="text-align: center">Status Mahasiswa</h5>
      <canvas id="ChartMHS_Status"></canvas>
      <p class="text-secondary" style="text-align: center">Kabupaten/Kota</p>
    </div>
</div>
    
  

 {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
 <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 <script type="text/javascript" src="https://unpkg.com/chartjs-chart-venn@3.6.0/build/index.umd.min.js"></script>
 
{{-- @dd($mhs_akt) --}}
<script>
    const mhs_akt = document.getElementById('ChartMHS_Angkatan'),
          biodata_kab = document.getElementById('ChartMHS_Kab'),
          status_mhs = document.getElementById('ChartMHS_Status');

    new Chart(mhs_akt, {
                type: 'bar',
                data: {
                  labels: [2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022,2023,2024],
                  datasets: [{
                    label: 'Jumlah Mahasiswa',
                    data: [{{$mhs_akt['2014']}},{{$mhs_akt['2015']}},{{$mhs_akt['2016']}},{{$mhs_akt['2017']}},{{$mhs_akt['2018']}},{{$mhs_akt['2019']}},{{$mhs_akt['2020']}},{{$mhs_akt['2021']}},{{$mhs_akt['2022']}},{{$mhs_akt['2023']}},{{$mhs_akt['2024']}},],
                    borderColor: '#36A2EB',
                    borderWidth: 2,
                  }]
                },
            
                options: {
                  scales: {
                    y: { // defining min and max so hiding the dataset does not change scale range
                      beginAtZero: true
                    }
                  }
                }
              });

    new Chart(biodata_kab, {
                type: 'bar',
                data: {
                  labels: ['Balangan', 'Banjar', 'Barito Kuala', 'HSS', 'HST', 'HSU', 'Kotabaru', 'Tabalong', 'Tanah Bumbu', 'Tanah Laut', 'Tapin', 'Banjarbaru', 'Banjarmasin'],
                  datasets: [{
                    label: 'Jumlah Mahasiswa Per-Kabupaten',
                    data: [{{$biodata_kab['Kab. Balangan']}},{{$biodata_kab['Kab. Banjar']}},{{$biodata_kab['Kab. Barito Kuala']}},{{$biodata_kab['Kab. Hulu Sungai Selatan']}},{{$biodata_kab['Kab. Hulu Sungai Tengah']}},{{$biodata_kab['Kab. Hulu Sungai Utara']}},{{$biodata_kab['Kab. Kotabaru']}},{{$biodata_kab['Kab. Tabalong']}},{{$biodata_kab['Kab. Tanah Bumbu']}},{{$biodata_kab['Kab. Tanah Laut']}},{{$biodata_kab['Kab. Tapin']}},{{$biodata_kab['Kota Banjarbaru']}},{{$biodata_kab['Kota Banjarmasin']}}],
                    borderColor: '#36A2EB',
                    borderWidth: 2,
                  }]
                },
            
                options: {
                  scales: {
                    y: { // defining min and max so hiding the dataset does not change scale range
                      beginAtZero: true
                    }
                  }
                }
              });

    new Chart(status_mhs, {
                type: 'bar',
                data: {
                  labels: ['Aktif', 'Lulus'],
                  datasets: [{
                    label: 'Status Mahasiswa',
                    data: [{{$status_mhs['Aktif']}}, {{$status_mhs['Lulus']}}],
                    borderColor: '#36A2EB',
                    borderWidth: 2,
                  }]
                },
            
                options: {
                  scales: {
                    y: { // defining min and max so hiding the dataset does not change scale range
                      beginAtZero: true
                    }
                  }
                }
              });
</script>