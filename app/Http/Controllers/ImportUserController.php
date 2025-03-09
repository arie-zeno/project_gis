<?php

namespace App\Http\Controllers;

use App\Imports\BiodataImport;
use App\Imports\SekolahImport;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

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

        Excel::import(new BiodataImport, $request->file('file'));

        toast('Data biodata berhasil diimport!', 'success')->position('center');
        return redirect()->back();
    }

    public function importSekolah(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new SekolahImport, $request->file('file'));

        toast('Data sekolah berhasil diimport!', 'success')->position('center');
        return redirect()->back();
    }
}
