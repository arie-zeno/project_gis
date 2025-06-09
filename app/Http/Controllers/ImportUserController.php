<?php

namespace App\Http\Controllers;

use App\Imports\BiodataImport;
use App\Imports\BioImport;
use App\Imports\SekolahImport;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use App\Jobs\UpdateKoordinatBiodataJob;
use App\Command\UpdateKoordinatBiodata;
use App\Command\UpdateDataSekolah;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class ImportUserController extends Controller
{

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new UsersImport, $request->file('file'));

        toast('Data pengguna berhasil diimport!', 'success')->position('center');
        return redirect()->back();
    }

    public function importBiodata(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');


        Excel::import(new BioImport, $request->file('file'));


        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Langsung panggil command generate koordinat
        Artisan::call('biodata:update-koordinat');

        toast('Data biodata berhasil diimport!', 'success')->position('center');
        return redirect()->back();
    }

    public function importSekolah(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new SekolahImport, $request->file('file'));

        // Langsung panggil command generate koordinat
        // Artisan::call('sekolah:update-data');

        toast('Data sekolah berhasil diimport!', 'success')->position('center');
        return redirect()->back();
    }
}
