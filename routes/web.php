<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\PermohonanCutiController;
use App\Http\Controllers\RiwayatPermohonanController;
use App\Http\Controllers\ForgotPasswordController;





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

//Reset Password
Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

//Reset Jumlah Cuti
Route::get('admin/resetJumlahCuti/dDFgdsErfCvdfErgEGldSp', [KaryawanController::class, 'resetJumlahCuti']);

//Kirim Pesan Sebelum 2 Hari Mulai Cuti
Route::get('admin/kirimPesan/kjDLeoerDfVderd', [PermohonanCutiController::class, 'kirimSebelumDuaHari']);

Route::group(['middleware' => 'auth'], function () {

    // Admin
    Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard')->middleware('hrd');

    Route::get('admin/dashboard/changeStatusBaru', [DashboardController::class, 'changeStatus'])->name('admin.changeStatusBaru');

    Route::get('admin/dashboard/cariPegawai', [DashboardController::class, 'searchNameAdmin'])->name('admin.searchNameAdmin');

    Route::get('admin/dashboard/filterDateReport', [DashboardController::class, 'filterDateReport'])->name('admin.filterDateReport');

    Route::get('admin/laporanCuti', [PermohonanCutiController::class, 'laporanCuti'])->name('permohonan.laporanCuti');

    Route::get('admin/dashboard/changeStatusDivisi', [DashboardController::class, 'changeStatusKaDivisi'])->name('admin.changeStatusKaDivisi');

    Route::get('admin/dashboard/cariDivisiPegawai', [DashboardController::class, 'searchNameKaDivisi'])->name('admin.searchNameKaDivisi');

    Route::get('kadivisi/dashboard', [DashboardController::class, 'indexKadivisi'])->name('kadivisi.dashboard')->middleware('kaDivisi');
    Route::get('admin/permohonan', [PermohonanCutiController::class, 'index'])->name('permohonan.index');
    Route::get('admin/permohonan/disetujui', [RiwayatPermohonanController::class, 'disetujui'])->name('permohonan.disetujui');
    Route::get('admin/permohonan/{id}', [PermohonanCutiController::class, 'dikirim'])->name('permohonan.dikirim');
    Route::get('admin/permohonan/setuju/{id}', [PermohonanCutiController::class, 'setuju'])->name('permohonan.setuju');
    Route::post('admin/permohonan/tolak/', [PermohonanCutiController::class, 'tolak'])->name('permohonan.tolak');
    Route::get('admin/karyawan', [KaryawanController::class, 'index'])->name('karyawan.index')->middleware('hrd');

    Route::get('admin/divisi', [DivisiController::class, 'index'])->name('divisi.index')->middleware('hrd');

    Route::get('karyawan/dashboard/{id}', [PermohonanCutiController::class, 'dibatalkan'])->name('permohonan.dibatalkan');

    Route::get('admin/karyawan/edit/{id}', [KaryawanController::class, 'edit'])->name('karyawan.edit');

    Route::get('admin/karyawan/editUser', [KaryawanController::class, 'editUser'])->name('karyawan.editUser');

    Route::get('admin/karyawan/destroy/{id}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy')->middleware('hrd');

    Route::post('admin/karyawan/update', [KaryawanController::class, 'update'])->name('karyawan.update')->middleware('hrd');

    Route::post('admin/User/update', [KaryawanController::class, 'updateUser'])->name('karyawan.updateUser')->middleware('hrd');

    Route::get('admin/karyawan/Create', [KaryawanController::class, 'create'])->name('karyawan.create')->middleware('hrd');

    Route::post('admin/karyawan/', [KaryawanController::class, 'store'])->name('karyawan.store')->middleware('hrd');

    Route::get('admin/divisi/CreateDivisi', [DivisiController::class, 'storeDivisi'])->name('divisi.store')->middleware('hrd');

    Route::get('admin/divisi/CreateJabatan', [DivisiController::class, 'storeJabatan'])->name('jabatan.store')->middleware('hrd');

    Route::get('admin/divisi/DestoryJabatan/{id}', [DivisiController::class, 'destroyJabatan'])->name('jabatan.destroy')->middleware('hrd');

    Route::post('suratPermohonanCuti/', [PermohonanCutiController::class, 'isiSurat'])->name('dataSurat.cuti');

    // Karyawan
    Route::get('karyawan/dashboard', [DashboardController::class, 'show'])->name('karyawan.dashboard');
    Route::get('karyawan/permohonan/disetujui', [RiwayatPermohonanController::class, 'disetujui'])->name('karyawan.permohonan.disetujui');
    Route::get('karyawan/permohonan/ditolak', [RiwayatPermohonanController::class, 'ditolak'])->name('karyawan.permohonan.ditolak');
    Route::post('karyawan', [PermohonanCutiController::class, 'store'])->name('permohonan.insert');

    Route::post('admin/permohonan/', [PermohonanCutiController::class, 'alasanTolak'])->name('permohonan.alasanTolak');

    Route::get('karyawan/permohonan', [PermohonanCutiController::class, 'show'])->name('karyawan.permohonan');

    Route::get('/calendar', [JabatanController::class, 'index'])->name('welcome');
});
