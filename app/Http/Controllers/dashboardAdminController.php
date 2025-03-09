<?php

namespace App\Http\Controllers;

use App\Models\Biodata;
use App\Models\Province;
use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class dashboardAdminController extends Controller
{
    public function index()
    {
        $user = User::with("biodata")->where("role", "!=", "admin")->get();
        $biodata = Biodata::with("user")->get();
        return view("dashboard.admin.index", [
            'title' => 'Dashboard',
            'biodata' => $biodata,
            'user' => $user,
        ]);
    }

    public function mahasiswa()
    {
        $user = User::with("biodata")->where("role", "!=", "admin")->orderByRaw("LEFT(nim, 2) ASC")->orderBy("name", "asc")->get();

        confirmDelete("Hapus Data", "Apakah anda yakin akan menghapus data ini?");
        // $biodata = Biodata::with("user")->get();
        return view("dashboard.admin.mahasiswa", [
            'title' => 'Mahasiswa',
            'user' => $user,
        ]);
    }

    public function sekolah()
    {
        $sekolah = Sekolah::paginate(10);
        $provinces = Province::all();

        confirmDelete("Hapus Data", "Apakah anda yakin akan menghapus data ini?");
        // $biodata = Biodata::with("user")->get();
        return view("dashboard.admin.sekolah", [
            'title' => 'Sekolah',
            'provinces' => $provinces,
            'sekolah' => $sekolah,
        ]);
    }

    public function tambahSekolah()
    {
        $provinces = Province::all();
        $sekolah = Sekolah::all();

        return view("dashboard.admin.tambahSekolah", [
            'title' => 'Sekolah',
            'provinces' => $provinces,
            'sekolah' => $sekolah,
        ]);
    }

    public function editSekolah($id)
    {
        $provinces = Province::all();
        $user = User::with("biodata")->where("role", "!=", "admin")->get();
        $sekolah = Sekolah::with("province")->find($id);
        return view("dashboard.admin.editSekolah", [
            'title' => 'Sekolah',
            'provinces' => $provinces,
            'sekolah' => $sekolah,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|string', // Pastikan NIM unik
            'nama' => 'required|string',
        ]);

        // Cek apakah data sudah ada
        $user = User::firstOrCreate(
            ['nim' => $request->nim], // Cek berdasarkan NIM
            [
                'name' => $request->nama,
                'role' => "mahasiswa",
                'email' => $request->nim . "@mhs.ulm.ac.id",
                'password' => Hash::make($request->nim),
            ]
        );

        // Redirect dengan pesan sukses atau info
        if ($user->wasRecentlyCreated) {
            alert()->success('Berhasil', $request->nama . " berhasil ditambahkan");
        } else {
            alert()->info('Gagal', $request->nama . " sudah ada dalam database");
        }

        return redirect()->back();
    }


    public function hapusMahasiswa($nim)
    {
        $user = User::where('nim', $nim)->first();

        if (!$user) {
            Alert::error('Gagal!', $nim . ' tidak ditemukan.');
            return redirect()->back();
        }

        $user->delete();

        Alert::success('Berhasil!', $nim . ' berhasil dihapus.');
        return redirect()->back();
    }

    public function hapusSekolah($id)
    {
        $sekolah = Sekolah::where('id', $id)->first();

        if (!$sekolah) {
            Alert::error('Gagal!', 'Sekolah tidak ditemukan.');
            return redirect()->back();
        }

        $sekolah->delete();

        Alert::success('Berhasil!', 'Sekolah berhasil dihapus.');
        return redirect()->back();
    }

    public function storeSekolah(Request $request)
    {
        // Validasi Input
        $request->validate([
            'id' => 'required',
            'nama_sekolah' => 'required',
            'jenis' => 'required',
            'status' => 'required',
        ]);


        Sekolah::create([
            'id' => $request->id,
            'nama_sekolah' => $request->nama_sekolah,
            'jenis' => $request->jenis,
            'status' => $request->status,
            'provinsi' => $request->provinsi,
            'kabupaten' => $request->kabupaten,
            'kecamatan' => $request->kecamatan,
            'kelurahan' => $request->kelurahan,
            'koordinat' => $request->koordinat,
        ]);




        // Redirect dengan pesan sukses
        alert("Berhasil", "Sekolah berhasil ditambahkan");
        return redirect()->route('admin.sekolah');
    }

    public function updateSekolah(Request $request)
    {
        // Validasi Input
        $request->validate([
            'id' => 'required',
            'nama_sekolah' => 'required',
            'jenis' => 'required',
            'status' => 'required',
        ]);

        $sekolah = Sekolah::find($request->id);
        $sekolah->nama_sekolah = $request->nama_sekolah;
        $sekolah->jenis = $request->jenis;
        $sekolah->status = $request->status;
        $sekolah->provinsi = $request->provinsi;
        $sekolah->kabupaten = $request->kabupaten;
        $sekolah->kecamatan = $request->kecamatan;
        $sekolah->kelurahan = $request->kelurahan;
        $sekolah->koordinat = $request->koordinat;
        $sekolah->save();



        // Redirect dengan pesan sukses
        alert("Berhasil", "Sekolah berhasil diperbarui");
        return redirect()->route('admin.sekolah');
    }

    public function gantiPassword(Request $request)
    {
        $user = User::find($request->nim);
        $user->password = Hash::make($request->password);
        $user->save();

        alert()->success("Berhasil", "Password telah diganti!",);
        return redirect()->back();
    }

    public function lihatMahasiswa($nim)
    {
        $biodata = Biodata::with(['user', 'sekolah', 'tempat_tinggal', 'province', 'regency', 'district', 'village'])->where('nim', $nim)->first();
        return view(
            'dashboard.admin.lihatMahasiswa',
            [
                'title' => 'Mahasiswa',
                'biodata' => $biodata
            ]
        );
    }
}
