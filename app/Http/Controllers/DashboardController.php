<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Models\Permohonan_Cuti;
use App\Models\Karyawan;


class DashboardController extends Controller
{
    public function index()
    {
        $permohonan = DB::table('users')
            ->join('permohonan_cuti','users.id','=','permohonan_cuti.user_id')
            ->select('users.name','permohonan_cuti.id','permohonan_cuti.alasan_cuti','permohonan_cuti.tgl_mulai','permohonan_cuti.tgl_akhir','permohonan_cuti.status','permohonan_cuti.ket_tolak','permohonan_cuti.durasi_cuti','permohonan_cuti.tgl_memohon')
            // ->where('permohonan_cuti.status','pending')
            // ->limit(5)
            ->get();
        $permohonanTerima = DB::table('users')
            ->join('permohonan_cuti','users.id','=','permohonan_cuti.user_id')
            ->join('karyawan','users.id','=','karyawan.user_id')
            ->select('users.name','karyawan.divisi','permohonan_cuti.id','permohonan_cuti.alasan_cuti','permohonan_cuti.tgl_mulai','permohonan_cuti.tgl_akhir','permohonan_cuti.status','permohonan_cuti.ket_tolak','permohonan_cuti.durasi_cuti','permohonan_cuti.tgl_memohon')
            ->where('permohonan_cuti.status','Diterima')
            // ->limit(5)
            ->get();
        $jmlPermohonan = Permohonan_Cuti::where('status', 'Baru')->get()->count();
        $jmlDiProses = Permohonan_Cuti::where('status', 'Diatasan')->get()->count();
        $jmlBatal = Permohonan_Cuti::where('status', 'Dibatalkan')->get()->count();
        $jmlPermohonanDisetujui = Permohonan_Cuti::where('status', 'Diterima')->get()->count();
        $jmlPermohonanDitolak = Permohonan_Cuti::where('status', 'Ditolak')->get()->count();
        
        
        return view('pages.Dashboard.DashboardAdmin',["permohonan" => $permohonan,"permohonanTerima" => $permohonanTerima,"jmlPermohonan" => $jmlPermohonan,'jmlPermohonanDisetujui' => $jmlPermohonanDisetujui,'jmlPermohonanDitolak' => $jmlPermohonanDitolak,'jmlBatal' => $jmlBatal,'jmlDiProses' => $jmlDiProses]);
    }
    public function show()
    {
        $id=Auth::user()->id;
        $permohonan = DB::table('users')
        ->join('permohonan_cuti','users.id','=','permohonan_cuti.user_id')
        ->join('karyawan','users.id','=','karyawan.user_id')
        ->select('users.name','permohonan_cuti.id','permohonan_cuti.alasan_cuti','permohonan_cuti.tgl_mulai','permohonan_cuti.tgl_akhir','permohonan_cuti.status','permohonan_cuti.ket_tolak','permohonan_cuti.durasi_cuti','permohonan_cuti.tgl_memohon','karyawan.jumlah_cuti')
        ->where('users.id',$id)
        // ->limit(5)
        ->get();
        $sisaCuti = DB::table('karyawan')->select('jumlah_cuti')->where('user_id',$id)->first();
        $jmlPermohonanDisetujui = Permohonan_Cuti::Where('status', 'disetujui')->where('user_id',$id)->get()->count();
        $jmlPermohonanDitolak = Permohonan_Cuti::where('status', 'ditolak')->where('user_id',$id)->get()->count();
       
        return view('pages.Dashboard.DashboardKaryawan',["permohonan" => $permohonan,'sisa_cuti' => $sisaCuti,'jmlPermohonanDisetujui' => $jmlPermohonanDisetujui,'jmlPermohonanDitolak' =>$jmlPermohonanDitolak]);
    }
}
