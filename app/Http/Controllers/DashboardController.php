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

            $permohonan = DB::table('users')
            ->join('permohonan_cuti','users.id','=','permohonan_cuti.user_id')
            ->join('karyawan','users.id','=','karyawan.user_id')
            ->select('users.name','users.role','karyawan.divisi','permohonan_cuti.id','permohonan_cuti.alasan_cuti','permohonan_cuti.tgl_mulai','permohonan_cuti.tgl_akhir','permohonan_cuti.status','permohonan_cuti.ket_tolak','permohonan_cuti.durasi_cuti','permohonan_cuti.tgl_memohon')
            // ->where('permohonan_cuti.status','Baru')
            ->orderBy('permohonan_cuti.created_at', "desc")
            // ->limit(5)
            ->paginate(10);
            
            // ->get();
            
        $permohonanTerima = DB::table('users')
            ->join('permohonan_cuti','users.id','=','permohonan_cuti.user_id')
            ->join('karyawan','users.id','=','karyawan.user_id')
            ->select('users.name','karyawan.divisi','permohonan_cuti.id','permohonan_cuti.alasan_cuti','permohonan_cuti.tgl_mulai','permohonan_cuti.tgl_akhir','permohonan_cuti.status','permohonan_cuti.ket_tolak','permohonan_cuti.durasi_cuti','permohonan_cuti.tgl_memohon','permohonan_cuti.warna_cuti')
            // ->where('permohonan_cuti.status','Diterima')
            ->where(function($query){
                $query->where('permohonan_cuti.status','Diterima');
                $query->orWhere('permohonan_cuti.status','Baru');
                $query->orWhere('permohonan_cuti.status','Diatasan');
            })
            // ->limit(5)
            ->get();
            
        $jmlPermohonan = Permohonan_Cuti::where('status', 'Baru')->get()->count();
        $jmlDiProses = Permohonan_Cuti::where('status', 'Diatasan')->get()->count();
        $jmlBatal = Permohonan_Cuti::where('status', 'Dibatalkan')->get()->count();
        $jmlPermohonanDisetujui = Permohonan_Cuti::where('status', 'Diterima')->get()->count();
        $jmlPermohonanDitolak = Permohonan_Cuti::where('status', 'Ditolak')->get()->count();

        return view('pages.Dashboard.DashboardAdmin',["permohonan" => $permohonan,"permohonanTerima" => $permohonanTerima,"jmlPermohonan" => $jmlPermohonan,'jmlPermohonanDisetujui' => $jmlPermohonanDisetujui,'jmlPermohonanDitolak' => $jmlPermohonanDitolak,'jmlBatal' => $jmlBatal,'jmlDiProses' => $jmlDiProses]);
    }

    public function searchNameAdmin(Request $request)
    {   
        
        // $cari = $request->searchName;

        $permohonan = DB::table('users')
            ->join('permohonan_cuti','users.id','=','permohonan_cuti.user_id')
            ->select('users.name','permohonan_cuti.id','permohonan_cuti.alasan_cuti','permohonan_cuti.tgl_mulai','permohonan_cuti.tgl_akhir','permohonan_cuti.status','permohonan_cuti.ket_tolak','permohonan_cuti.durasi_cuti','permohonan_cuti.tgl_memohon')
            ->where('users.name','LIKE','%'.$request->searchName.'%')
            ->orderBy('permohonan_cuti.created_at', "desc")
            // ->limit(5)
            ->paginate(10);
            
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

    public function changeStatus(Request $request)
    {   
        
        $permohonanGet = DB::table('users')
            ->join('permohonan_cuti','users.id','=','permohonan_cuti.user_id')
            ->select('users.name','permohonan_cuti.id','permohonan_cuti.alasan_cuti','permohonan_cuti.tgl_mulai','permohonan_cuti.tgl_akhir','permohonan_cuti.status','permohonan_cuti.ket_tolak','permohonan_cuti.durasi_cuti','permohonan_cuti.tgl_memohon');

        if ($request->namaStatus == "Baru"){
            $permohonan = $permohonanGet
            ->where('permohonan_cuti.status','Baru')
            ->orderBy('permohonan_cuti.created_at', "desc")
            ->paginate(10);
        } elseif ($request->namaStatus == "Diterima"){
            $permohonan = $permohonanGet
            ->where('permohonan_cuti.status','Diterima')
            ->orderBy('permohonan_cuti.created_at', "desc")
            ->paginate(10);
        }elseif ($request->namaStatus == "Diatasan"){
            $permohonan = $permohonanGet
            ->where('permohonan_cuti.status','Diatasan')
            ->orderBy('permohonan_cuti.created_at', "desc")
            ->paginate(10);
        }elseif ($request->namaStatus == "Dibatalkan"){
            $permohonan = $permohonanGet
            ->where('permohonan_cuti.status','Dibatalkan')
            ->orderBy('permohonan_cuti.created_at', "desc")
            ->paginate(10);
        }elseif ($request->namaStatus == "Ditolak"){
            $permohonan = $permohonanGet
            ->where('permohonan_cuti.status','Ditolak')
            ->orderBy('permohonan_cuti.created_at', "desc")
            ->paginate(10);
        }elseif ($request->namaStatus == "Semua"){
            $permohonan = DB::table('users')
            ->join('permohonan_cuti','users.id','=','permohonan_cuti.user_id')
            ->select('users.name','permohonan_cuti.id','permohonan_cuti.alasan_cuti','permohonan_cuti.tgl_mulai','permohonan_cuti.tgl_akhir','permohonan_cuti.status','permohonan_cuti.ket_tolak','permohonan_cuti.durasi_cuti','permohonan_cuti.tgl_memohon')
            // ->where('permohonan_cuti.status','Baru')
            ->orderBy('permohonan_cuti.created_at', "desc")
            // ->limit(5)
            ->paginate(10);
        }
            
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
            ->orderBy('permohonan_cuti.created_at', "desc");
            // ->where('permohonan_cuti.status','pending')
            // ->limit(5)
            // ->get();
            $permohonanTerima = DB::table('users')
            ->join('permohonan_cuti','users.id','=','permohonan_cuti.user_id')
            ->join('karyawan','users.id','=','karyawan.user_id')
            ->select('users.name','karyawan.divisi','permohonan_cuti.id','permohonan_cuti.alasan_cuti','permohonan_cuti.tgl_mulai','permohonan_cuti.tgl_akhir','permohonan_cuti.status','permohonan_cuti.ket_tolak','permohonan_cuti.durasi_cuti','permohonan_cuti.tgl_memohon','permohonan_cuti.warna_cuti')
            // ->where('permohonan_cuti.status','Diterima')
            ->where(function($query){
                $query->where('permohonan_cuti.status','Diterima');
                $query->orWhere('permohonan_cuti.status','Baru');
                $query->orWhere('permohonan_cuti.status','Diatasan');
            });
            // ->limit(5)
            
            // ->limit(5)
            // ->get();

        $jmlPermohonan = Permohonan_Cuti::where('status', 'Baru')->get()->count();
        $jmlDiProses = Permohonan_Cuti::where('status', 'Diatasan')->get()->count();
        $jmlBatal = Permohonan_Cuti::where('status', 'Dibatalkan')->get()->count();
        $jmlPermohonanDisetujui = Permohonan_Cuti::where('status', 'Diterima')->get()->count();
        $jmlPermohonanDitolak = Permohonan_Cuti::where('status', 'Ditolak')->get()->count();

        $permohonanDivisi = $permohonan->where('karyawan.divisi', Auth::user()->karyawan->divisi)->paginate(10);
        

        $calendarAdmin = $permohonanTerima->get();

        $calendarDivisi = $permohonanTerima->where('karyawan.divisi', Auth::user()->karyawan->divisi)->get();
        
        return view('pages.Dashboard.DashboardKaDivisi',["permohonan" => $permohonan,"permohonanDivisi"=>$permohonanDivisi,"permohonanTerima" => $calendarAdmin, "calendarDivisi" => $calendarDivisi, "jmlPermohonan" => $jmlPermohonan,'jmlPermohonanDisetujui' => $jmlPermohonanDisetujui,'jmlPermohonanDitolak' => $jmlPermohonanDitolak,'jmlBatal' => $jmlBatal,'jmlDiProses' => $jmlDiProses]);
    }

    public function searchNameKaDivisi(Request $request)
    {   
        
        // $cari = $request->searchName;

        $permohonan = DB::table('users')
            ->join('permohonan_cuti','users.id','=','permohonan_cuti.user_id')
            ->join('karyawan','users.id','=','karyawan.user_id')
            ->select('users.name','permohonan_cuti.id','permohonan_cuti.alasan_cuti','permohonan_cuti.tgl_mulai','permohonan_cuti.tgl_akhir','permohonan_cuti.status','permohonan_cuti.ket_tolak','permohonan_cuti.durasi_cuti','permohonan_cuti.tgl_memohon')
            ->orderBy('permohonan_cuti.created_at', "desc")
            ->where('users.name','LIKE','%'.$request->searchName.'%');
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

        $permohonanDivisi = $permohonan->where('karyawan.divisi', Auth::user()->karyawan->divisi)->paginate(10);;
        

        $calendarAdmin = $permohonanTerima->get();

        $calendarDivisi = $permohonanTerima->where('karyawan.divisi', Auth::user()->karyawan->divisi)->get();
        
        return view('pages.Dashboard.DashboardKaDivisi',["permohonan" => $permohonan,"permohonanDivisi"=>$permohonanDivisi,"permohonanTerima" => $calendarAdmin, "calendarDivisi" => $calendarDivisi, "jmlPermohonan" => $jmlPermohonan,'jmlPermohonanDisetujui' => $jmlPermohonanDisetujui,'jmlPermohonanDitolak' => $jmlPermohonanDitolak,'jmlBatal' => $jmlBatal,'jmlDiProses' => $jmlDiProses]);
        
    }

    public function changeStatusKaDivisi(Request $request)
    {   
        
        $permohonanGet = DB::table('users')
        ->join('permohonan_cuti','users.id','=','permohonan_cuti.user_id')
        ->join('karyawan','users.id','=','karyawan.user_id')
        ->select('users.name','permohonan_cuti.id','permohonan_cuti.alasan_cuti','permohonan_cuti.tgl_mulai','permohonan_cuti.tgl_akhir','permohonan_cuti.status','permohonan_cuti.ket_tolak','permohonan_cuti.durasi_cuti','permohonan_cuti.tgl_memohon')
        ->orderBy('permohonan_cuti.created_at', "desc");

        if ($request->namaStatus == "Baru"){
            $permohonan = $permohonanGet
            ->where('permohonan_cuti.status','Baru')
            ->orderBy('permohonan_cuti.created_at', "desc");
            
        } elseif ($request->namaStatus == "Diterima"){
            $permohonan = $permohonanGet
            ->where('permohonan_cuti.status','Diterima')
            ->orderBy('permohonan_cuti.created_at', "desc");
            
        }elseif ($request->namaStatus == "Diatasan"){
            $permohonan = $permohonanGet
            ->where('permohonan_cuti.status','Diatasan')
            ->orderBy('permohonan_cuti.created_at', "desc");
        
        }elseif ($request->namaStatus == "Dibatalkan"){
            $permohonan = $permohonanGet
            ->where('permohonan_cuti.status','Dibatalkan')
            ->orderBy('permohonan_cuti.created_at', "desc");
            
        }elseif ($request->namaStatus == "Ditolak"){
            $permohonan = $permohonanGet
            ->where('permohonan_cuti.status','Ditolak')
            ->orderBy('permohonan_cuti.created_at', "desc");
            
        }elseif ($request->namaStatus == "Semua"){
            $permohonan = DB::table('users')
            ->join('permohonan_cuti','users.id','=','permohonan_cuti.user_id')
            ->join('karyawan','users.id','=','karyawan.user_id')
            ->select('users.name','permohonan_cuti.id','permohonan_cuti.alasan_cuti','permohonan_cuti.tgl_mulai','permohonan_cuti.tgl_akhir','permohonan_cuti.status','permohonan_cuti.ket_tolak','permohonan_cuti.durasi_cuti','permohonan_cuti.tgl_memohon');
            // ->limit(5)
            
        }
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

        $permohonanDivisi = $permohonan->where('karyawan.divisi', Auth::user()->karyawan->divisi)->paginate(10);
        

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
        ->orderBy('permohonan_cuti.created_at', "desc")
        // ->limit(5)
        ->paginate(10);

        $permohonanTerima = DB::table('users')
            ->join('permohonan_cuti','users.id','=','permohonan_cuti.user_id')
            ->join('karyawan','users.id','=','karyawan.user_id')
            ->select('users.name','karyawan.divisi','permohonan_cuti.id','permohonan_cuti.alasan_cuti','permohonan_cuti.tgl_mulai','permohonan_cuti.tgl_akhir','permohonan_cuti.status','permohonan_cuti.ket_tolak','permohonan_cuti.durasi_cuti','permohonan_cuti.tgl_memohon')
            ->where('permohonan_cuti.status','Diterima');

        $getRagneTanggal = DB::table('users')
            ->join('permohonan_cuti','users.id','=','permohonan_cuti.user_id')
            ->join('karyawan','users.id','=','karyawan.user_id')
            ->select('users.name','permohonan_cuti.tgl_mulai','permohonan_cuti.tgl_akhir','karyawan.divisi','permohonan_cuti.id','permohonan_cuti.alasan_cuti','permohonan_cuti.tgl_mulai','permohonan_cuti.tgl_akhir','permohonan_cuti.status','permohonan_cuti.ket_tolak','permohonan_cuti.durasi_cuti','permohonan_cuti.tgl_memohon','permohonan_cuti.warna_cuti')
            // ->where(
            //     function($query) {
            //         return $query
            //             ->where('permohonan_cuti.status','Diterima')
            //             ->orWhere('permohonan_cuti.status','Baru');
            //     })
            ->where(function($query){
                    $query->where('permohonan_cuti.status','Diterima');
                    $query->orWhere('permohonan_cuti.status','Baru');
                    $query->orWhere('permohonan_cuti.status','Diatasan');
                })
            ->where('karyawan.divisi', Auth::user()->karyawan->divisi)
            ->get();

        // $getRagneTanggal = '2022-10-25';

        
        $sisaCuti = DB::table('karyawan')->where('user_id',$id)->value('jumlah_cuti');
        $jmlPermohonanDisetujui = Permohonan_Cuti::Where('status', 'disetujui')->where('user_id',$id)->get()->count();
        $jmlPermohonanDitolak = Permohonan_Cuti::where('status', 'ditolak')->where('user_id',$id)->get()->count();

        $calendarAdmin = $permohonanTerima->get();

        $calendarDivisi = $permohonanTerima->where('karyawan.divisi', Auth::user()->karyawan->divisi)->get();

        return view('pages.Dashboard.DashboardKaryawan',["permohonan" => $permohonan,'sisa_cuti' => $sisaCuti,'jmlPermohonanDisetujui' => $jmlPermohonanDisetujui,"calendarDivisi" => $calendarDivisi,'jmlPermohonanDitolak' =>$jmlPermohonanDitolak,'getRagneTanggal'=>$getRagneTanggal]);
    }
}
