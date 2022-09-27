<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Models\Permohonan_Cuti;
use App\Models\Karyawan;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function index()
    {
        $city = 'Sales';
        $permohonan = DB::table('users')
            ->join('permohonan_cuti','users.id','=','permohonan_cuti.user_id')
            ->join('karyawan','users.id','=','karyawan.user_id')
            ->select('users.name','permohonan_cuti.id','permohonan_cuti.alasan_cuti','permohonan_cuti.tgl_mulai','permohonan_cuti.tgl_akhir','permohonan_cuti.status','permohonan_cuti.ket_tolak','permohonan_cuti.durasi_cuti','permohonan_cuti.tgl_memohon','karyawan.divisi')
            ->where('permohonan_cuti.status','pending')
            // ->limit(5)
            // ->orderBy('permohonan_cuti.created_at')
            ->whereHas(
                'karyawan',
                function ($query) use ($city) {
                    $query->where('divisi', 'LIKE', "%{$city}%");
                }
            )
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

    public function indexKadivisi()
    {
        $permohonan = DB::table('users')
            ->join('permohonan_cuti','users.id','=','permohonan_cuti.user_id')
            ->join('karyawan','users.id','=','karyawan.user_id')
            ->select('users.name','permohonan_cuti.id','permohonan_cuti.alasan_cuti','permohonan_cuti.tgl_mulai','permohonan_cuti.tgl_akhir','permohonan_cuti.status','permohonan_cuti.ket_tolak','permohonan_cuti.durasi_cuti','permohonan_cuti.tgl_memohon')
            ->orderBy('permohonan_cuti.created_at');
            // ->where('permohonan_cuti.status','pending')
            // ->limit(5)
            // ->get();
        $permohonanTerima = DB::table('users')
            ->join('permohonan_cuti','users.id','=','permohonan_cuti.user_id')
            ->join('karyawan','users.id','=','karyawan.user_id')
            ->select('users.name','karyawan.divisi','permohonan_cuti.id','permohonan_cuti.alasan_cuti','permohonan_cuti.tgl_mulai','permohonan_cuti.tgl_akhir','permohonan_cuti.status','permohonan_cuti.ket_tolak','permohonan_cuti.durasi_cuti','permohonan_cuti.tgl_memohon')
            ->where('permohonan_cuti.status','Diterima');
            // ->limit(5)
            // ->get();

        $jmlPermohonan = Permohonan_Cuti::where('status', 'Baru')->get()->count();
        $jmlDiProses = Permohonan_Cuti::where('status', 'Diatasan')->get()->count();
        $jmlBatal = Permohonan_Cuti::where('status', 'Dibatalkan')->get()->count();
        $jmlPermohonanDisetujui = Permohonan_Cuti::where('status', 'Diterima')->get()->count();
        $jmlPermohonanDitolak = Permohonan_Cuti::where('status', 'Ditolak')->get()->count();

        $permohonanDivisi = $permohonan->where('karyawan.divisi', Auth::user()->karyawan->divisi)->get();
        

        $calendarAdmin = $permohonanTerima->get();

        $calendarDivisi = $permohonanTerima->where('karyawan.divisi', Auth::user()->karyawan->divisi)->get();
        
        return view('pages.Dashboard.DashboardKaDivisi',["permohonan" => $permohonan,"permohonanDivisi"=>$permohonanDivisi,"permohonanTerima" => $calendarAdmin, "calendarDivisi" => $calendarDivisi, "jmlPermohonan" => $jmlPermohonan,'jmlPermohonanDisetujui' => $jmlPermohonanDisetujui,'jmlPermohonanDitolak' => $jmlPermohonanDitolak,'jmlBatal' => $jmlBatal,'jmlDiProses' => $jmlDiProses]);
    }

    public function show()
    {
        $id=Auth::user()->id;
        $permohonan = DB::table('users')
        ->join('permohonan_cuti','users.id','=','permohonan_cuti.user_id')
        ->join('karyawan','users.id','=','karyawan.user_id')
        ->select('users.name','permohonan_cuti.id','permohonan_cuti.alasan_cuti','permohonan_cuti.tgl_mulai','permohonan_cuti.tgl_akhir','permohonan_cuti.status','permohonan_cuti.ket_tolak','permohonan_cuti.durasi_cuti','permohonan_cuti.tgl_memohon','karyawan.jumlah_cuti')
        ->where('users.id',$id)
        ->orderBy('permohonan_cuti.created_at')
        // ->limit(5)
        ->get();

        $permohonanTerima = DB::table('users')
            ->join('permohonan_cuti','users.id','=','permohonan_cuti.user_id')
            ->join('karyawan','users.id','=','karyawan.user_id')
            ->select('users.name','karyawan.divisi','permohonan_cuti.id','permohonan_cuti.alasan_cuti','permohonan_cuti.tgl_mulai','permohonan_cuti.tgl_akhir','permohonan_cuti.status','permohonan_cuti.ket_tolak','permohonan_cuti.durasi_cuti','permohonan_cuti.tgl_memohon')
            ->where('permohonan_cuti.status','Diterima');

        
        $sisaCuti = DB::table('karyawan')->where('user_id',$id)->value('jumlah_cuti');
        $jmlPermohonanDisetujui = Permohonan_Cuti::Where('status', 'disetujui')->where('user_id',$id)->get()->count();
        $jmlPermohonanDitolak = Permohonan_Cuti::where('status', 'ditolak')->where('user_id',$id)->get()->count();

        $calendarAdmin = $permohonanTerima->get();

        $calendarDivisi = $permohonanTerima->where('karyawan.divisi', Auth::user()->karyawan->divisi)->get();
       
        return view('pages.Dashboard.DashboardKaryawan',["permohonan" => $permohonan,'sisa_cuti' => $sisaCuti,'jmlPermohonanDisetujui' => $jmlPermohonanDisetujui,"calendarDivisi" => $calendarDivisi,'jmlPermohonanDitolak' =>$jmlPermohonanDitolak]);
    }
}
