<?php

namespace App\Http\Controllers;

use App\Models\Biodata;
use App\Models\User;
use Illuminate\Http\Request;

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

    public function mahasiswa(){
        $user = User::with("biodata")->where("role", "!=", "admin")->get();
        // $biodata = Biodata::with("user")->get();
        return view("dashboard.admin.mahasiswa", [
            'title' => 'Mahasiswa',
            'user' => $user,
        ]);
    }
}
