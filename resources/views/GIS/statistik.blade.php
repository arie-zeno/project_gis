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

    .chart-row {
    display: flex;
    justify-content: center;
    gap: 2rem;
    flex-wrap: wrap;
    margin: 2rem;
  }

  .chart-box {
    width: 500px;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 12px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    background-color: #fff;
    transition: 0.5s;
  }

  .chart-box:hover {
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  }

  canvas {
    width: 100% !important;
    height: 300px !important;
  }

  h5 {
    margin-bottom: 10px;
    font-weight: bold;
  }

  .text-secondary {
    font-size: 0.85rem;
    color: #6c757d;
  }

</style>
<style>
  .bd-placeholder-img {
    font-size: 1.125rem;
    text-anchor: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
  }

  @media (min-width: 568px) {
    .bd-placeholder-img-lg {
      font-size: 3.5rem;
    }
  }

  .b-example-divider {
    width: 100%;
    height: 3rem;
    background-color: rgba(0, 0, 0, .1);
    border: solid rgba(0, 0, 0, .15);
    border-width: 1px 0;
    box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
  }

  .b-example-vr {
    flex-shrink: 0;
    width: 1.5rem;
    height: 100vh;
  }

  .bi {
    vertical-align: -.125em;
    fill: currentColor;
  }

  .nav-scroller {
    position: relative;
    z-index: 2;
    height: 2.75rem;
    overflow-y: hidden;
  }

  .nav-scroller .nav {
    display: flex;
    flex-wrap: nowrap;
    padding-bottom: 1rem;
    margin-top: -1px;
    overflow-x: auto;
    text-align: center;
    white-space: nowrap;
    -webkit-overflow-scrolling: touch;
  }

  .btn-bd-primary {
    --bd-violet-bg: #712cf9;
    --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

    --bs-btn-font-weight: 600;
    --bs-btn-color: var(--bs-white);
    --bs-btn-bg: var(--bd-violet-bg);
    --bs-btn-border-color: var(--bd-violet-bg);
    --bs-btn-hover-color: var(--bs-white);
    --bs-btn-hover-bg: #6528e0;
    --bs-btn-hover-border-color: #6528e0;
    --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
    --bs-btn-active-color: var(--bs-btn-hover-color);
    --bs-btn-active-bg: #5a23c8;
    --bs-btn-active-border-color: #5a23c8;
  }
  .bd-mode-toggle {
    z-index: 1500;
  }
  @media (max-width: 767.98px) {
    .container-home img{
      display:none;
    }

    .container-home{
      display: flex;
      justify-content: center;
      align-items: center
    }
    .container-home h1{
      line-height: 35px;
    }
  }
</style>
<div style="padding: 30px">
  <div class="chart-row">
    <div class="chart-box">
      <h5 style="text-align: center">Jumlah Mahasiswa Per-Angkatan</h5>
      <canvas id="ChartMHS_Angkatan"></canvas>
      <p class="text-secondary" style="text-align: center">Angkatan</p>
    </div>
  
    <div class="chart-box">
      <h5 style="text-align: center">Asal Mahasiswa</h5>
      <canvas id="ChartMHS_Kab"></canvas>
      <p class="text-secondary" style="text-align: center">Jumlah Mahasiswa</p>
    </div>

    <div class="chart-box">
      <h5 style="text-align: center">Status Mahasiswa</h5>
      <canvas id="ChartMHS_Status"></canvas>
      <p class="text-secondary" style="text-align: center">Status</p>
    </div>

    <div class="chart-box">
      <h5 style="text-align: center">Data Mahasiswa Berdasarkan Jenis Kelamin</h5>
      <canvas id="ChartMHS_JK"></canvas>
      <p class="text-secondary" style="text-align: center">Jenis Kelamin</p>
    </div>

    <div class="chart-box">
      <h5 style="text-align: center">Jumlah Mahasiswa Berdasarkan Jenis Sekolah</h5>
      <canvas id="ChartMHS_JS"></canvas>
      <p class="text-secondary" style="text-align: center">Jenis Sekolah</p>
    </div>

    <div class="chart-box">
      <h5 style="text-align: center">Jumlah Mahasiswa Berdasarkan Kabupaten Sekolah</h5>
      <canvas id="ChartMHS_KS"></canvas>
      <p class="text-secondary" style="text-align: center">Jumlah Mahasiswa</p>
    </div>
</div>

    
  

 {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
 <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 <script type="text/javascript" src="https://unpkg.com/chartjs-chart-venn@3.6.0/build/index.umd.min.js"></script>
 
 <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>

 <!-- Tambahkan plugin datalabel -->
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

{{-- @dd($mhs_akt) --}}
<script>

  const chartColors = [
    '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
    '#858796', '#fd7e14', '#20c997', '#0dcaf0', '#6610f2',
    '#6f42c1', '#198754', '#d63384'
  ];        
          
  // 1. Mahasiswa per Angkatan
  new Chart(document.getElementById('ChartMHS_Angkatan'), {
    type: 'bar',
    data: {
      labels: [2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024],
      datasets: [{
        label: 'Jumlah Mahasiswa',
        data: [{{$mhs_akt['2014']}},{{$mhs_akt['2015']}},{{$mhs_akt['2016']}},{{$mhs_akt['2017']}},{{$mhs_akt['2018']}},{{$mhs_akt['2019']}},{{$mhs_akt['2020']}},{{$mhs_akt['2021']}},{{$mhs_akt['2022']}},{{$mhs_akt['2023']}},{{$mhs_akt['2024']}}],
        backgroundColor: '#4e73df',
        borderRadius: 5,
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: '#f8f9fc',
          titleColor: '#4e73df',
          bodyColor: '#858796',
          borderColor: '#dddfeb',
          borderWidth: 1
        },
        datalabels: {
          color: '#111',
          anchor: 'end',
          align: 'top',
          font: { weight: 'bold' }
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 1
          }
        }
      }
    },
    plugins: [ChartDataLabels]
  });

  // 2. Mahasiswa per Kabupaten
  new Chart(document.getElementById('ChartMHS_Kab'), {
    type: 'bar',
    data: {
      labels: ['Balangan', 'Banjar', 'Barito Kuala', 'HSS', 'HST', 'HSU', 'Kotabaru', 'Tabalong', 'Tanah Bumbu', 'Tanah Laut', 'Tapin', 'Banjarbaru', 'Banjarmasin'],
      datasets: [{
        label: 'Jumlah Mahasiswa',
        data: [{{$biodata_kab['Kab. Balangan']}},{{$biodata_kab['Kab. Banjar']}},{{$biodata_kab['Kab. Barito Kuala']}},{{$biodata_kab['Kab. Hulu Sungai Selatan']}},{{$biodata_kab['Kab. Hulu Sungai Tengah']}},{{$biodata_kab['Kab. Hulu Sungai Utara']}},{{$biodata_kab['Kab. Kotabaru']}},{{$biodata_kab['Kab. Tabalong']}},{{$biodata_kab['Kab. Tanah Bumbu']}},{{$biodata_kab['Kab. Tanah Laut']}},{{$biodata_kab['Kab. Tapin']}},{{$biodata_kab['Kota Banjarbaru']}},{{$biodata_kab['Kota Banjarmasin']}}],
        backgroundColor: chartColors,
        borderRadius: 4,
      }]
    },
    options: {
      indexAxis: 'y',
      responsive: true,
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: '#fff',
          titleColor: '#000',
          bodyColor: '#333',
          borderColor: '#ccc',
          borderWidth: 1
        },
        datalabels: {
          color: '#111',
          anchor: 'center',
          align: 'right',
          font: { weight: 'bold' }
        }
      },
      scales: {
        x: {
          beginAtZero: true
        },
        y: {
          ticks: {
            font: {
              size: 9 // kecilkan agar muat semua label
            }
          }
        }
      }
    },
    plugins: [ChartDataLabels]
  });

  // 3. Status Mahasiswa
  new Chart(document.getElementById('ChartMHS_Status'), {
    type: 'doughnut',
    data: {
      labels: ['Aktif', 'Lulus'],
      datasets: [{
        label: 'Jumlah Mahasiswa',
        data: [{{$status_mhs['Aktif']}}, {{$status_mhs['Lulus']}}],
        backgroundColor: ['#1cc88a', '#e74a3b'],
        hoverOffset: 10,
        borderWidth: 2,
        borderColor: '#fff',
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'bottom',
          labels: { color: '#333', padding: 20 }
        },
        tooltip: {
          backgroundColor: '#f9f9f9',
          titleColor: '#000',
          bodyColor: '#555',
          borderColor: '#ccc',
          borderWidth: 1
        },
      }
    }
  });

  // 4. Jenis Kelamin Mahasiswa
    new Chart(document.getElementById('ChartMHS_JK'), {
    type: 'doughnut',
    data: {
      labels: ['Laki-laki', 'Perempuan'],
      datasets: [{
        label: 'Jumlah Mahasiswa',
        data: [{{$jk_mhs['Laki-laki']}}, {{$jk_mhs['Perempuan']}}],
        backgroundColor: ['#347dc1', '#cc6594'],
        hoverOffset: 10,
        borderWidth: 2,
        borderColor: '#fff',
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'bottom',
          labels: { color: '#333', padding: 20 }
        },
        tooltip: {
          backgroundColor: '#f9f9f9',
          titleColor: '#000',
          bodyColor: '#555',
          borderColor: '#ccc',
          borderWidth: 1
        },
      }
    }
  });


    // 5. Jumlah Mahasiswa per-Jenis Sekolah
    new Chart(document.getElementById('ChartMHS_JS'), {
    type: 'bar',
    data: {
      labels: ['SMA', 'SMK', 'MA', "Lainnya"],
      datasets: [{
        label: 'Jumlah Mahasiswa',
        data: [{{$jmlh_jenissekolah['SMA']}},{{$jmlh_jenissekolah['SMK']}},{{$jmlh_jenissekolah['MA']}},{{$jmlh_jenissekolah['Lainnya']}}],
        backgroundColor: ['#d63384', '#4e73df', '#1cc88a', '#36b9cc'],
        borderRadius: 5,
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: '#f8f9fc',
          titleColor: '#4e73df',
          bodyColor: '#858796',
          borderColor: '#dddfeb',
          borderWidth: 1
        },
        datalabels: {
          color: '#111',
          anchor: 'end',
          align: 'top',
          font: { weight: 'bold' }
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 1
          }
        }
      }
    },
    plugins: [ChartDataLabels]
  });

 // 6. Mahasiswa per Kabupaten
 new Chart(document.getElementById('ChartMHS_KS'), {
    type: 'bar',
    data: {
      labels: ['Balangan', 'Banjar', 'Barito Kuala', 'HSS', 'HST', 'HSU', 'Kotabaru', 'Tabalong', 'Tanah Bumbu', 'Tanah Laut', 'Tapin', 'Banjarbaru', 'Banjarmasin'],
      datasets: [{
        label: 'Jumlah Mahasiswa',
        data: [{{$jmlh_kabsekolah['Balangan']}},{{$jmlh_kabsekolah['Banjar']}},{{$jmlh_kabsekolah['Barito Kuala']}},{{$jmlh_kabsekolah['Hulu Sungai Selatan']}},{{$jmlh_kabsekolah['Hulu Sungai Tengah']}},{{$jmlh_kabsekolah['Hulu Sungai Utara']}},{{$jmlh_kabsekolah['Kotabaru']}},{{$jmlh_kabsekolah['Tabalong']}},{{$jmlh_kabsekolah['Tanah Bumbu']}},{{$jmlh_kabsekolah['Tanah Laut']}},{{$jmlh_kabsekolah['Tapin']}},{{$jmlh_kabsekolah['Banjarbaru']}},{{$jmlh_kabsekolah['Banjarmasin']}}],
        backgroundColor: chartColors,
        borderRadius: 4,
      }]
    },
    options: {
      indexAxis: 'y',
      responsive: true,
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: '#fff',
          titleColor: '#000',
          bodyColor: '#333',
          borderColor: '#ccc',
          borderWidth: 1
        },
        datalabels: {
          color: '#111',
          anchor: 'center',
          align: 'right',
          font: { weight: 'bold' }
        }
      },
      scales: {
        x: {
          beginAtZero: true
        },
        y: {
          ticks: {
            font: {
              size: 9 // kecilkan agar muat semua label
            }
          }
        }
      }
    },
    plugins: [ChartDataLabels]
  });
</script>
