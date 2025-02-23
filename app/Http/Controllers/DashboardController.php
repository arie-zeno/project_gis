<?php

namespace App\Http\Controllers;

use App\Models\Biodata;
use App\Models\Province;
use App\Models\Sekolah;
use App\Models\Tempat_Tinggal;
use App\Models\TempatTinggal;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function home()
    {
        $biodata = Biodata::with(['user', 'sekolah', 'tempat_tinggal', 'province', 'regency', 'district', 'village'])->where('nim', auth()->user()->nim)->first();
        return view(
            'dashboard.mahasiswa.home',
            [
                'title' => 'Dashboard',
                'biodata' => $biodata
            ]
        );
    }

    public function biodata()
    {
        $biodata = Biodata::with(['user', 'sekolah', 'tempat_tinggal', 'province', 'regency', 'district', 'village'])->where('nim', auth()->user()->nim)->first();
        return view('dashboard.mahasiswa.biodata', [
            'title' => 'Biodata',
            'biodata' => $biodata,
        ]);
    }

    public function sekolah()
    {
        $biodata = Biodata::with(['user', 'sekolah', 'tempat_tinggal', 'province', 'regency', 'district', 'village'])->where('nim', auth()->user()->nim)->first();
        return view('dashboard.mahasiswa.sekolah', [
            'title' => 'Sekolah',
            'biodata' => $biodata,
        ]);
    }

    public function tempat()
    {
        $biodata = Biodata::with(['user', 'sekolah', 'tempat_tinggal', 'province', 'regency', 'district', 'village'])->where('nim', auth()->user()->nim)->first();
        return view('dashboard.mahasiswa.tempat', [
            'title' => 'Domisili',
            'biodata' => $biodata,
        ]);
    }

    public function create()
    {
        $provinces = Province::all();
        // $biodata = Biodata::with(['user', 'sekolah', 'tempat_tinggal'])->where('nim',auth()->user()->nim)->first();
        return view('dashboard.mahasiswa.create', [
            'title' => 'Biodata',
            'provinces' => $provinces,
        ]);
    }
    public function store(Request $request)
    {
        // Validasi Input
        $request->validate([
            'telepon' => 'required|string',
            'angkatan' => 'required|string',
            'jenis_kelamin' => 'required|string',
            'agama' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'tempat_lahir' => 'required|string',
            'provinsi' => 'required|string',
            'kabupaten' => 'required|string',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'koordinat' => 'required|string',
            'penghasilan' => 'required|string',
            'id_sekolah' => 'nullable|exists:sekolah,id',
            'id_tempat_tinggal' => 'nullable|exists:tempat_tinggal,id',
            'tanggal_lahir' => 'required|date'
        ]);

        // Jika ada file foto yang diupload
        if ($request->hasFile('foto')) {
            // Simpan file ke folder storage/app/public/foto
            $path = $request->file('foto')->store('foto_mahasiswa', 'public');
        } else {
            $path = null;
        }

        // Simpan Data
        Biodata::create([
            'id_biodata' => auth()->user()->nim,
            'nim' => auth()->user()->nim,
            'nama' => auth()->user()->name,
            'telepon' => $request->telepon,
            'angkatan' => $request->angkatan,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama' => $request->agama,
            'foto' => $path,
            'tempat_lahir' => $request->tempat_lahir,
            'provinsi' => $request->provinsi,
            'kabupaten' => $request->kabupaten,
            'kecamatan' => $request->kecamatan,
            'kelurahan' => $request->kelurahan,
            'koordinat' => $request->koordinat,
            'penghasilan' => $request->penghasilan,
            'tanggal_lahir' => $request->tanggal_lahir
        ]);

        // Redirect dengan pesan sukses
        alert("Success", "Biodata berhasil ditambahkan");
        return redirect()->route('mahasiswa.biodata');
    }

    public function createSekolah()
    {
        $sekolah = Sekolah::all();
        $provinces = Province::all();
        // $biodata = Biodata::with(['user', 'sekolah', 'tempat_tinggal'])->where('nim',auth()->user()->nim)->first();
        return view('dashboard.mahasiswa.createSekolah', [
            'title' => 'Biodata',
            'provinces' => $provinces,
            'sekolah' => $sekolah,
        ]);
    }

    public function createTempat()
    {
        $tempat = TempatTinggal::all();
        $provinces = Province::all();
        // $biodata = Biodata::with(['user', 'sekolah', 'tempat_tinggal'])->where('nim',auth()->user()->nim)->first();
        return view('dashboard.mahasiswa.createTempat', [
            'title' => 'Biodata',
            'provinces' => $provinces,
            'tempat' => $tempat,
        ]);
    }

    public function storeSekolah(Request $request)
    {
        // Validasi Input
        $request->validate([
            'id_sekolah' => 'required',
            'nama_sekolah' => 'nullable|string|max:255',
        ]);

        $biodata = Biodata::findOrFail(auth()->user()->nim);
        // Jika user memilih "Tambah Sekolah"
        if ($request->id_sekolah === "tambah") {
            // Buat sekolah baru
            $sekolah = Sekolah::create([
                'id' => $request->id,
                'nama_sekolah' => $request->nama_sekolah,
                'provinsi' => $request->provinsi,
                'kabupaten' => $request->kabupaten,
                'kecamatan' => $request->kecamatan,
                'kelurahan' => $request->kelurahan,
                'koordinat' => $request->koordinat,
            ]);

            // Update biodata dengan id_sekolah yang baru
            $biodata->update([
                'id_sekolah' => $sekolah->id,
            ]);
        } else {
            // Jika memilih sekolah yang sudah ada, cukup update id_sekolah
            $biodata->update([
                'id_sekolah' => $request->id,
            ]);
        }


        // Redirect dengan pesan sukses
        alert("Success", "Riwayat Pendidikan berhasil ditambahkan");
        return redirect()->route('mahasiswa.sekolah');
    }

    public function storeTempat(Request $request)
    {
        // Validasi Input
        $request->validate([
            'id' => 'required',
        ]);

        $biodata = Biodata::findOrFail(auth()->user()->nim);
        // Jika user memilih "Tambah Sekolah"
      $tempat = TempatTinggal::create([
                'id' => $request->id,
                'provinsi' => $request->provinsi,
                'kabupaten' => $request->kabupaten,
                'kecamatan' => $request->kecamatan,
                'kelurahan' => $request->kelurahan,
                'koordinat' => $request->koordinat,
            ]);

            // Update biodata dengan id_sekolah yang baru
            $biodata->update([
                'id_tempat_tinggal' => $tempat->id,
            ]);
        


        // Redirect dengan pesan sukses
        alert("Success", "Asal Daerah berhasil ditambahkan");
        return redirect()->route('mahasiswa.tempat');
    }

    public function settings()
    {
        return view('dashboard.mahasiswa.settings', ['title' => 'Settings']);
    }
}
