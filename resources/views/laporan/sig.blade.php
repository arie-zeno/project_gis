<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Laporan Persebaran Mahasiswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
            color: #000;
        }
        h1, h2, h3, h4 {
            text-align: center;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 6px 8px;
            text-align: center;
            vertical-align: middle;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .no-border {
            border: none !important;
            text-align: center;
        }
        .page-break {
            page-break-after: always;
        }
        ul {
            margin-left: 20px;
        }
    </style>
</head>
<body>

    {{-- 1. Sampul --}}
    <div class="no-border" style="margin-top: 150px;">
        <h1>LAPORAN PERSEBARAN MAHASISWA</h1>
        <h2>PROGRAM STUDI PENDIDIKAN KOMPUTER</h2>
        <h3>UNIVERSITAS LAMBUNG MANGKURAT</h3>
        <p><strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>
    </div>

    <div class="page-break"></div>

    {{-- 2. Ringkasan Umum --}}
    <h3>Ringkasan Umum</h3>
    <table>
        <thead>
            <tr>
                <th>Keterangan</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>Jumlah Seluruh Mahasiswa</td><td>{{ $total }}</td></tr>
            <tr><td>Jumlah Mahasiswa Aktif</td><td>{{ $totalAktif }}</td></tr>
            <tr><td>Jumlah Alumni</td><td>{{ $totalAlumni }}</td></tr>
        </tbody>
    </table>

    {{-- 3. Statistik Persebaran --}}
    <h3>Statistik Persebaran Mahasiswa per Kabupaten/Kota</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kabupaten/Kota</th>
                <th>Jumlah Mahasiswa</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse($biodata_kab as $kab => $jumlah)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $kab }}</td>
                    <td>{{ $jumlah }}</td>
                </tr>
            @empty
                <tr><td colspan="3">Data tidak tersedia</td></tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="page-break"></div>

    <h3>Statistik Alumni per Kabupaten/Kota</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kabupaten/Kota</th>
                <th>Jumlah Alumni</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse($lulus_kab as $kab => $jumlah)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $kab }}</td>
                    <td>{{ $jumlah }}</td>
                </tr>
            @empty
                <tr><td colspan="3">Data tidak tersedia</td></tr>
            @endforelse
        </tbody>
    </table>

    <h3>Statistik Mahasiswa Aktif per Kabupaten/Kota</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kabupaten/Kota</th>
                <th>Jumlah Mahasiswa Aktif</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse($aktif_kab as $kab => $jumlah)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $kab }}</td>
                    <td>{{ $jumlah }}</td>
                </tr>
            @empty
                <tr><td colspan="3">Data tidak tersedia</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="page-break"></div>

    {{-- 4. Data Mahasiswa --}}
    <h3>Data Mahasiswa</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIM</th>
                <th>Angkatan</th>
                <th>Status</th>
                <th>Kabupaten Asal</th>
                <th>Sekolah Asal</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse($biodata as $m)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $m->nama }}</td>
                    <td>{{ $m->nim }}</td>
                    <td>{{ $m->angkatan }}</td>
                    <td>{{ ucfirst($m->status) }}</td>
                    <td>{{ $m->kabupaten }}</td>
                    <td>{{ optional($m->sekolah)->nama_sekolah ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="7">Data mahasiswa tidak tersedia</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="page-break"></div>

    {{-- 5. Analisis dan Rekomendasi --}}
    <h3>Analisis dan Rekomendasi</h3>
    <ul>
        <li>Kabupaten yang memiliki jumlah mahasiswa masih sedikit menjadi fokus promosi lebih lanjut, <br> dengan dilakukan pendekatan ke sekolah-sekolah lokal..</li>
        <li>Mahasiswa dari luar Kalsel menunjukkan adanya potensi rekrutmen nasional.</li>
        <li>Pemetaan alumni bisa dikembangkan untuk tracer study dan penguatan jaringan kerja sama.</li>
    </ul>

</body>
</html>
