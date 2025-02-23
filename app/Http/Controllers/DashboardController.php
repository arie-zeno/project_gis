<?php

namespace App\Http\Controllers;

use App\Models\Biodata;
use App\Models\Province;
use App\Models\Sekolah;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function home()
    {
        $biodata = Biodata::with(['user', 'sekolah', 'tempat_tinggal'])->where('nim', auth()->user()->nim)->first();
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
        $biodata = Biodata::with(['user', 'sekolah', 'tempat_tinggal'])->where('nim', auth()->user()->nim)->first();
        return view('dashboard.mahasiswa.biodata', [
            'title' => 'Biodata',
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

    public function settings()
    {
        return view('dashboard.mahasiswa.settings', ['title' => 'Settings']);
    }
}
