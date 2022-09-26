<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use PDF;
use App\Models\User;

class RiwayatPermohonanController extends Controller
{
    
    public function disetujui()
    {
        if(Auth::user()->role === 'karyawan'){
            $id = Auth::user()->id;
            $permohonan = DB::table('users')
            ->join('permohonan_cuti','users.id','=','permohonan_cuti.user_id')
            ->select('permohonan_cuti.id','users.name','permohonan_cuti.alasan_cuti','permohonan_cuti.tgl_mulai','permohonan_cuti.tgl_akhir','permohonan_cuti.status')
            ->where('permohonan_cuti.status','disetujui')
            ->where('users.id',$id)
            ->get();
        }else{
            $permohonan = DB::table('users')
                ->join('permohonan_cuti','users.id','=','permohonan_cuti.user_id')
                ->select('permohonan_cuti.id','users.name','permohonan_cuti.alasan_cuti','permohonan_cuti.tgl_mulai','permohonan_cuti.tgl_akhir','permohonan_cuti.status')
                ->where('permohonan_cuti.status','disetujui')
                ->get();
        }

        return view('pages.permohonanCuti.disetujui',['permohonan' => $permohonan]);
    }

    public function cetakSurat(){
        $id=Auth::user()->id;
        $permohonan = DB::table('users')
        ->join('permohonan_cuti','users.id','=','permohonan_cuti.user_id')
        ->join('karyawan','users.id','=','karyawan.user_id')
        ->select('users.name','permohonan_cuti.id','permohonan_cuti.alasan_cuti','permohonan_cuti.tgl_mulai','permohonan_cuti.tgl_akhir','permohonan_cuti.status','permohonan_cuti.ket_tolak','permohonan_cuti.durasi_cuti','permohonan_cuti.tgl_memohon','karyawan.jumlah_cuti')
        ->where('users.id',$id)
        // ->limit(5)
        ->get();
        $pdf = PDF::loadView('pages.Dashboard.DashboardKaryawanCetak',compact('permohonan'));
        $pdf->setPaper('A4','potrait');
        return $pdf->stream('suratCuti.pdf');
    }
    
    public function ditolak()
    {
        if(Auth::user()->role === 'karyawan'){
            $id = Auth::user()->id;
            $permohonan = DB::table('users')
                ->join('permohonan_cuti','permohonan_cuti.id','users.id','=','permohonan_cuti.user_id')
                ->select('permohonan_cuti.id','users.name','permohonan_cuti.alasan_cuti','permohonan_cuti.tgl_mulai','permohonan_cuti.tgl_akhir','permohonan_cuti.status')
                ->where('permohonan_cuti.status','ditolak')
                ->where('users.id',$id)

                ->get();
        }else{
            $permohonan = DB::table('users')
                ->join('permohonan_cuti','permohonan_cuti.id','users.id','=','permohonan_cuti.user_id')
                ->select('permohonan_cuti.id','users.name','permohonan_cuti.alasan_cuti','permohonan_cuti.tgl_mulai','permohonan_cuti.tgl_akhir','permohonan_cuti.status')
                ->where('permohonan_cuti.status','ditolak')
                ->get();
        }

        return view('pages.permohonanCuti.ditolak',['permohonan' => $permohonan]);

    }
}
