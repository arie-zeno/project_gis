<?php

namespace App\Http\Controllers;

use App\Models\Biodata;
use App\Models\Province;
use App\Models\District;
use App\Models\Regency;
use App\Models\Village;
use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class dashboardAdminController extends Controller
{
    public function index()
    {
        $user = User::with("biodata")->where("role", "!=", "admin")->get();
        $biodata = Biodata::with("user")->get();
        $sekolah = Sekolah::all();

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

        $jk_mhs = [
            "Laki-laki" => 0,
            "Perempuan" => 0,
        ];
        foreach($biodata as $data){
            if($data["jenis_kelamin"] == "Laki-laki"){
                $jk_mhs["Laki-laki"]+=1;
            } else if($data["jenis_kelamin"] == "Perempuan"){
                $jk_mhs["Perempuan"]+=1;
            }
        } 

        $mhs_sekolah = Biodata::with('sekolah')->get();

        $jmlh_jenissekolah = [
            "SMA" => 0,
            "SMK" => 0,
            "MA" => 0,
            "Lainnya" => 1,
        ];

        foreach($mhs_sekolah as $item){
            $jenis = ($item->sekolah->jenis ?? '');
            if($jenis == "SMA"){
                $jmlh_jenissekolah["SMA"]+=1;
            } else if($jenis == "SMK"){
                $jmlh_jenissekolah["SMK"]+=1;
            } else if($jenis == "MA"){
                $jmlh_jenissekolah["MA"]+=1;
            } else if($jenis == "Lainnya"){
                $jmlh_jenissekolah["Lainnya"]+=1;
            }
        }

        $jmlh_kabsekolah = [
            "Banjarbaru" => 0,
            "Banjarmasin" => 0,
            "Balangan" => 0,
            "Banjar" => 0,
            "Barito Kuala" => 0,
            "Hulu Sungai Selatan" => 0,
            "Hulu Sungai Tengah" => 0,
            "Hulu Sungai Utara" => 0,
            "Kotabaru" => 0,
            "Tabalong" => 0,
            "Tanah Bumbu" => 0,
            "Tanah Laut" => 0,
            "Tapin" => 0
        ];

        
        foreach($mhs_sekolah as $item){
            $kab_sekolah = ($item->sekolah->kabupaten ?? '');
            if($kab_sekolah == "Banjarbaru"){
                $jmlh_kabsekolah["Banjarbaru"]+=1;
            } else if($kab_sekolah == "Banjarmasin"){
                $jmlh_kabsekolah["Banjarmasin"]+=1;
            } else if($kab_sekolah == "Balangan"){
                $jmlh_kabsekolah["Balangan"]+=1;
            } else if($kab_sekolah == "Banjar"){
                $jmlh_kabsekolah["Banjar"]+=1;
            } else if($kab_sekolah == "Barito Kuala"){
                $jmlh_kabsekolah["Barito Kuala"]+=1;
            } else if($kab_sekolah == "Hulu Sungai Selatan"){
                $jmlh_kabsekolah["Hulu Sungai Selatan"]+=1;
            } else if($kab_sekolah == "Hulu Sungai Tengah"){
                $jmlh_kabsekolah["Hulu Sungai Tengah"]+=1;
            } else if($kab_sekolah == "Hulu Sungai Utara"){
                $jmlh_kabsekolah["Hulu Sungai Utara"]+=1;
            } else if($kab_sekolah == "Kotabaru"){
                $jmlh_kabsekolah["Kotabaru"]+=1;
            } else if($kab_sekolah == "Tabalong"){
                $jmlh_kabsekolah["Tabalong"]+=1;
            } else if($kab_sekolah == "Tanah Bumbu"){
                $jmlh_kabsekolah["Tanah Bumbu"]+=1;
            } else if($kab_sekolah == "Tanah Laut"){
                $jmlh_kabsekolah["Tanah Laut"]+=1;
            } else if($kab_sekolah == "Tapin"){
                $jmlh_kabsekolah["Tapin"]+=1;
            }
        }

        
        return view("dashboard.admin.index", [
            'title' => 'Dashboard',
            'biodata' => $biodata,
            'user' => $user,
            "mhs_akt" => $mhs_akt,
            "biodata_kab" => $biodata_kab,
            "status_mhs" => $status_mhs,
            "jk_mhs" => $jk_mhs,                
            "jmlh_jenissekolah" => $jmlh_jenissekolah,
            "jmlh_kabsekolah" => $jmlh_kabsekolah
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
        $sekolah = Sekolah::paginate(200);
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

    public function biodata()
    {
        $biodata = Biodata::with(['user', 'sekolah', 'tempat_tinggal', 'province', 'regency', 'district', 'village'])->where('nim', auth()->user()->nim)->first();
        return view('dashboard.mahasiswa.biodata', [
            'title' => 'Biodata',
            'biodata' => $biodata,
        ]);
    }
    

    public function createBiodata()
    {
        $provinces = Province::all();
        // $biodata = Biodata::with(['user', 'sekolah', 'tempat_tinggal'])->where('nim',auth()->user()->nim)->first();
        return view('dashboard.mahasiswa.create', [
            'title' => 'Biodata',
            'provinces' => $provinces,
        ]);
    }
    public function storeBiodata(Request $request)
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
        return redirect()->route('mahasiswa.home');
    }

    public function hapusMahasiswa($nim)
    {
        $user = User::where('nim', $nim)->first();
        $biodata =Biodata::where('id_biodata', $nim)->first();

        if (!$user) {
            Alert::error('Gagal!', $nim . ' tidak ditemukan.');
            return redirect()->back();
        }

        $user->delete();
        
        if ($biodata) {
            $biodata->delete();
        }

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

        $provinsi = Province::where('id', $request->provinsi)->first();
        $kabupaten = Regency::where('id', $request->kabupaten)->first();
        $kecamatan = District::where('id', $request->kecamatan)->first(); 
        $kelurahan = Village::where('id', $request->kelurahan)->first();    
        Sekolah::create([
            'id' => $request->nama_sekolah,
            'nama_sekolah' => $request->nama_sekolah,
            'jenis' => $request->jenis,
            'status' => $request->status,
            'provinsi'  => Str::title(Str::lower($provinsi->name)),
            'kabupaten' => Str::title(Str::replaceFirst('kabupaten ', '', Str::replaceFirst('kota ', '', Str::lower($kabupaten->name)))),
            'kecamatan' => Str::title(Str::lower($kecamatan->name)),
            'kelurahan' => Str::title(Str::lower($kelurahan->name)),
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

    public function gantiStatus(Request $request)
    {
        $request->validate([
            'status' => 'required|in:Aktif,Lulus',
        ]);
        $user = Biodata::find($request->nim);
        // dd($request->status);
        $user->status = $request->status;
        $user->save();

        alert()->success("Berhasil", "Status telah diubah!",);
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


    // public function formUbahStatus($nim)
    // {
    //     $mahasiswa = Biodata::where('nim', $nim)->firstOrFail();

    //     return view('mahasiswa.ubah_status', compact('mahasiswa'));
    // }

    public function prosesUbahStatus(Request $request, $nim)
    {
        $request->validate([
            'status' => 'required|in:Aktif,Lulus',
        ]);

        $mahasiswa = Biodata::where('nim', $nim)->firstOrFail();
        $mahasiswa->status = $request->status;
        $mahasiswa->save();

        return back()->with('success', 'Status berhasil diperbarui.');
    }

}
