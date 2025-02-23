<?php

use App\Http\Controllers\dashboardAdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GisController;
use App\Http\Controllers\IndoRegionController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});


// Route::prefix('dashboard')->group(function () {
//   Route::get('/', [DashboardController::class, 'home'])->name('dashboard.home');
//   Route::get('/profile', [DashboardController::class, 'profile'])->name('dashboard.profile');
//   Route::get('/settings', [DashboardController::class, 'settings'])->name('dashboard.settings');
// });

// Dashboard Admin

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', [dashboardAdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard', [dashboardAdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/mahasiswa', [dashboardAdminController::class, 'mahasiswa'])->name('admin.mahasiswa');
});
// Dashboard Mahasiswa
Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->group(function () {
    Route::get('/', [DashboardController::class, 'home'])->name('mahasiswa.home');
    Route::get('/dashboard', [DashboardController::class, 'home'])->name('mahasiswa.home');
    Route::get('/biodata', [DashboardController::class, 'biodata'])->name('mahasiswa.biodata');
    Route::get('/biodata/isi', [DashboardController::class, 'create'])->name('isi.biodata');
    Route::post('/biodata', [DashboardController::class, 'store'])->name('store.biodata');
});


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// GIS
Route::get('/gis-mahasiswa', [GisController::class, 'tempatTinggal'])->name('gis.mahasiswa');

// Indoregion

Route::post('/getKabupaten', [IndoRegionController::class, "getKabupaten"])->name('getKabupaten')->middleware("auth");
Route::post('/getKecamatan', [IndoRegionController::class, "getKecamatan"])->name('getKecamatan')->middleware("auth");
Route::post('/getKelurahan', [IndoRegionController::class, "getKelurahan"])->name('getKelurahan')->middleware("auth");
