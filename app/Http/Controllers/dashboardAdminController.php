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
        $user = User::with("biodata")->where("role", "!=", "admin")->orderByRaw("LEFT(nim, 2) ASC")->orderBy("name", "asc")->paginate(10);

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

    public function store(Request $request)
    {
        // Validasi Input
        $request->validate([
            'nim' => 'required|string',
            'nama' => 'required|string',

        ]);


        // Simpan Data
        User::create([
            'nim' => $request->nim,
            'name' => $request->nama,
            'role' => "mahasiswa",
            'email' => $request->nim . "@mhs.ulm.ac.id",
            'password' => Hash::make($request->nim),
        ]);

        // Redirect dengan pesan sukses
        alert("Success", $request->nama . " berhasil ditambahkan");
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

    public function gantiPassword(Request $request)
    {
        $user = User::find($request->nim);
        $user->password = Hash::make($request->password);
        $user->save();

        alert()->success("Berhasil", "Password telah diganti!",);
        return redirect()->back();
    }
}
