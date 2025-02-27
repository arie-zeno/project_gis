<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class ImportUserController extends Controller
{
    public function showForm()
    {
        return view('admin.import'); // Menampilkan halaman upload
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new UsersImport, $request->file('file'));

        toast('Data pengguna berhasil diimport!', 'success')->position('center');
        return redirect()->back();
    }
}
