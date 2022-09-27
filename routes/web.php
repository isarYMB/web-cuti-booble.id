<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\PermohonanCutiController;
use App\Http\Controllers\RiwayatPermohonanController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
 
Route::get('/', [AuthController::class, 'showFormLogin'])->name('login');
Route::get('login', [AuthController::class, 'showFormLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
 
Route::group(['middleware' => 'auth'], function () {
    
    // Admin
    Route::get('admin/dashboard',[DashboardController::class, 'index'])->name('admin.dashboard');
    
    Route::get('kadivisi/dashboard',[DashboardController::class, 'indexKadivisi'])->name('kadivisi.dashboard');
    Route::get('admin/permohonan',[PermohonanCutiController::class, 'index'])->name('permohonan.index');
    Route::get('admin/permohonan/disetujui',[RiwayatPermohonanController::class, 'disetujui'])->name('permohonan.disetujui');
    Route::get('admin/permohonan/{id}',[PermohonanCutiController::class, 'dikirim'])->name('permohonan.dikirim');
    // Route::get('admin/permohonan/ditolak',[RiwayatPermohonanController::class, 'ditolak'])->name('permohonan.ditolak');
    Route::get('admin/permohonan/setuju/{id}',[PermohonanCutiController::class, 'setuju'])->name('permohonan.setuju');
    Route::post('admin/permohonan/tolak/',[PermohonanCutiController::class, 'tolak'])->name('permohonan.tolak');
    Route::get('admin/karyawan',[KaryawanController::class, 'index'])->name('karyawan.index');

    

    Route::get('admin/divisi',[DivisiController::class, 'index'])->name('divisi.index');

    //harus diubah jadi post
    Route::get('karyawan/dashboard/{id}',[PermohonanCutiController::class, 'dibatalkan'])->name('permohonan.dibatalkan');

    Route::get('admin/karyawan/edit/{id}',[KaryawanController::class, 'edit'])->name('karyawan.edit');

    Route::get('admin/karyawan/editUser',[KaryawanController::class, 'editUser'])->name('karyawan.editUser');

    Route::get('admin/karyawan/destroy/{id}',[KaryawanController::class, 'destroy'])->name('karyawan.destroy');

    Route::post('admin/karyawan/update',[KaryawanController::class, 'update'])->name('karyawan.update');

    Route::post('admin/User/update',[KaryawanController::class, 'updateUser'])->name('karyawan.updateUser');

    Route::get('admin/karyawan/Create',[KaryawanController::class, 'create'])->name('karyawan.create');

    Route::post('admin/karyawan/',[KaryawanController::class, 'store'])->name('karyawan.store');

    Route::get('admin/divisi/CreateDivisi',[DivisiController::class, 'storeDivisi'])->name('divisi.store');

    Route::get('admin/divisi/CreateJabatan',[DivisiController::class, 'storeJabatan'])->name('jabatan.store');

    Route::get('admin/divisi/DestoryJabatan/{id}',[DivisiController::class, 'destroyJabatan'])->name('jabatan.destroy');

    Route::post('suratPermohonanCuti/',[PermohonanCutiController::class, 'isiSurat'])->name('dataSurat.cuti');
    
    // Karyawan
    //harus diubah jadi post
    Route::get('karyawan/dashboard',[DashboardController::class, 'show'])->name('karyawan.dashboard');
    Route::get('karyawan/permohonan/disetujui',[RiwayatPermohonanController::class, 'disetujui'])->name('karyawan.permohonan.disetujui');
    Route::get('karyawan/permohonan/ditolak',[RiwayatPermohonanController::class, 'ditolak'])->name('karyawan.permohonan.ditolak');
    Route::post('karyawan',[PermohonanCutiController::class, 'store'])->name('permohonan.insert');

    // Route::post('/setNamaAtasan',[PermohonanCutiController::class, 'isiSurat'])->name('namaAtasan.isiSurat');
    
    Route::post('admin/permohonan/',[PermohonanCutiController::class, 'alasanTolak'])->name('permohonan.alasanTolak');

    
    Route::get('karyawan/permohonan',[PermohonanCutiController::class, 'show'])->name('karyawan.permohonan');

    Route::get('/calendar', [JabatanController::class, 'index'])->name('welcome');

    // Route::get('/cetak-surat',[RiwayatPermohonanController::class, 'cetakSurat']);
});





