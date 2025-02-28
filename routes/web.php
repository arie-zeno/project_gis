<?php

use App\Http\Controllers\dashboardAdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GisController;
use App\Http\Controllers\ImportUserController;
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
    Route::post('/mahasiswa', [dashboardAdminController::class, 'store'])->name('store.mahasiswa');
    Route::delete('/mahasiswa/hapus/{nim}', [dashboardAdminController::class, 'hapusMahasiswa'])->name('hapus.mahasiswa');
    Route::get('/mahasiswa/lihat/{nim}', [dashboardAdminController::class, 'lihatMahasiswa'])->name('lihat.mahasiswa');
    
    Route::post('/mahasiswa/ganti/{nim}', [dashboardAdminController::class, 'gantiPassword'])->name('ganti.password');
    
    Route::get('/sekolah', [dashboardAdminController::class, 'sekolah'])->name('admin.sekolah');
    Route::get('/sekolah/tambah', [dashboardAdminController::class, 'tambahSekolah'])->name('tambah.sekolah');
    Route::post('/sekolah', [dashboardAdminController::class, 'storeSekolah'])->name('admin.store.sekolah');
    Route::delete('/sekolah/hapus/{id}', [dashboardAdminController::class, 'hapusSekolah'])->name('hapus.sekolah');
    Route::get('/sekolah/edit/{id}', [dashboardAdminController::class, 'editSekolah'])->name('edit.sekolah');
    Route::post('/sekolah/edit', [dashboardAdminController::class, 'updateSekolah'])->name('update.sekolah');

});
// Dashboard Mahasiswa
Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->group(function () {
    Route::get('/', [DashboardController::class, 'home'])->name('mahasiswa.home');
    Route::get('/dashboard', [DashboardController::class, 'home'])->name('mahasiswa.home');
    Route::get('/biodata', [DashboardController::class, 'biodata'])->name('mahasiswa.biodata');
    Route::get('/sekolah', [DashboardController::class, 'sekolah'])->name('mahasiswa.sekolah');
    Route::get('/tempat', [DashboardController::class, 'tempat'])->name('mahasiswa.tempat');
    Route::get('/biodata/isi', [DashboardController::class, 'create'])->name('isi.biodata');
    Route::post('/biodata', [DashboardController::class, 'store'])->name('store.biodata');

    Route::get('/biodata/sekolah', [DashboardController::class, 'createSekolah'])->name('isi.sekolah');
    Route::post('/sekolah', [DashboardController::class, 'storeSekolah'])->name('store.sekolah');

    Route::get('/biodata/tempat', [DashboardController::class, 'createTempat'])->name('isi.tempat');
    Route::post('/tempat', [DashboardController::class, 'storeTempat'])->name('store.tempat');
});


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// GIS
Route::get('/', [GisController::class, 'home'])->name('gis.home');
Route::get('/home', [GisController::class, 'home'])->name('gis.home');
Route::get('/gis-mahasiswa', [GisController::class, 'tempatTinggal'])->name('gis.mahasiswa');
Route::get('/gis-sekolah', [GisController::class, 'sekolah'])->name('gis.sekolah');
Route::get('/gis-domisili', [GisController::class, 'domisili'])->name('gis.domisili');

// Indoregion

Route::post('/getKabupaten', [IndoRegionController::class, "getKabupaten"])->name('getKabupaten')->middleware("auth");
Route::post('/getKecamatan', [IndoRegionController::class, "getKecamatan"])->name('getKecamatan')->middleware("auth");
Route::post('/getKelurahan', [IndoRegionController::class, "getKelurahan"])->name('getKelurahan')->middleware("auth");

// Import
Route::post('/admin/import-users', [ImportUserController::class, 'import'])->name('import.users');