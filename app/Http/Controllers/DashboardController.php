<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;;

use Auth;
use App\Models\Permohonan_Cuti;
use App\Models\Karyawan;
use Carbon\Carbon;


class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $permohonan = DB::table('users')
            ->join('permohonan_cuti', 'users.id', '=', 'permohonan_cuti.user_id')
            ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
            ->select('users.name', 'users.role', 'karyawan.divisi', 'permohonan_cuti.id', 'permohonan_cuti.alasan_cuti', 'permohonan_cuti.tgl_mulai', 'permohonan_cuti.tgl_akhir', 'permohonan_cuti.status', 'permohonan_cuti.ket_tolak', 'permohonan_cuti.durasi_cuti', 'permohonan_cuti.tgl_memohon')
            // ->where('permohonan_cuti.status','Di Ka.Divisi')
            ->orderBy('permohonan_cuti.created_at', "desc")
            // ->limit(5)
            ->paginate(10);

        // ->get();

        $permohonanTerima = DB::table('users')
            ->join('permohonan_cuti', 'users.id', '=', 'permohonan_cuti.user_id')
            ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
            ->select('users.name', 'karyawan.divisi', 'permohonan_cuti.id', 'permohonan_cuti.alasan_cuti', 'permohonan_cuti.tgl_mulai', 'permohonan_cuti.tgl_akhir', 'permohonan_cuti.status', 'permohonan_cuti.ket_tolak', 'permohonan_cuti.durasi_cuti', 'permohonan_cuti.tgl_memohon', 'permohonan_cuti.warna_cuti')
            // ->where('permohonan_cuti.status','Diterima')
            ->where(function ($query) {
                $query->where('permohonan_cuti.status', 'Diterima');
                $query->orWhere('permohonan_cuti.status', 'Di Ka.Divisi');
                $query->orWhere('permohonan_cuti.status', 'Di Direktur');
            })
            // ->limit(5)
            ->get();

        $jmlPermohonan = Permohonan_Cuti::where('status', 'Di Ka.Divisi')->get()->count();
        $jmlDiProses = Permohonan_Cuti::where('status', 'Di Direktur')->get()->count();
        $jmlTotalPengajuan = $jmlPermohonan + $jmlDiProses;
        $jmlBatal = Permohonan_Cuti::where('status', 'Dibatalkan')->get()->count();
        $jmlPermohonanDisetujui = Permohonan_Cuti::where('status', 'Diterima')->get()->count();
        $jmlPermohonanDitolak = Permohonan_Cuti::where('status', 'Ditolak')->get()->count();

        return view('pages.Dashboard.DashboardAdmin', ["permohonan" => $permohonan, "permohonanTerima" => $permohonanTerima, "jmlPermohonan" => $jmlPermohonan, 'jmlPermohonanDisetujui' => $jmlPermohonanDisetujui, 'jmlPermohonanDitolak' => $jmlPermohonanDitolak, 'jmlBatal' => $jmlBatal, 'jmlDiProses' => $jmlDiProses, 'jmlTotalPengajuan' => $jmlTotalPengajuan]);
    }

    public function filterDateReport(Request $request)
    {

        $dates = explode(' - ', $request->daterange);
        $start_date = Carbon::parse($dates[0])->toDateString();
        $end_date = Carbon::parse($dates[1])->toDateString();


        $permohonan = DB::table('users')
            ->join('permohonan_cuti', 'users.id', '=', 'permohonan_cuti.user_id')
            ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
            ->select('users.name', 'permohonan_cuti.id', 'permohonan_cuti.alasan_cuti', 'permohonan_cuti.tgl_mulai', 'permohonan_cuti.tgl_akhir', 'permohonan_cuti.status', 'permohonan_cuti.ket_tolak', 'permohonan_cuti.durasi_cuti', 'permohonan_cuti.tgl_memohon', 'permohonan_cuti.warna_cuti', 'karyawan.divisi', 'users.role')
            ->orderBy('permohonan_cuti.created_at', "desc")
            ->whereBetween('permohonan_cuti.tgl_mulai', [$start_date, $end_date])
            ->where('permohonan_cuti.status', 'Diterima')
            // ->limit(5)
            ->paginate(10);

        $permohonanTerima = DB::table('users')
            ->join('permohonan_cuti', 'users.id', '=', 'permohonan_cuti.user_id')
            ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
            ->select('users.name', 'karyawan.divisi', 'permohonan_cuti.id', 'permohonan_cuti.alasan_cuti', 'permohonan_cuti.tgl_mulai', 'permohonan_cuti.tgl_akhir', 'permohonan_cuti.status', 'permohonan_cuti.ket_tolak', 'permohonan_cuti.durasi_cuti', 'permohonan_cuti.tgl_memohon', 'permohonan_cuti.warna_cuti')
            ->where(function ($query) {
                $query->where('permohonan_cuti.status', 'Diterima');
                $query->orWhere('permohonan_cuti.status', 'Di Ka.Divisi');
                $query->orWhere('permohonan_cuti.status', 'Di Direktur');
            })
            // ->limit(5)
            ->get();

        $jmlPermohonan = Permohonan_Cuti::where('status', 'Di Ka.Divisi')->get()->count();
        $jmlDiProses = Permohonan_Cuti::where('status', 'Di Direktur')->get()->count();
        $jmlTotalPengajuan = $jmlPermohonan + $jmlDiProses;
        $jmlBatal = Permohonan_Cuti::where('status', 'Dibatalkan')->get()->count();
        $jmlPermohonanDisetujui = Permohonan_Cuti::where('status', 'Diterima')->get()->count();
        $jmlPermohonanDitolak = Permohonan_Cuti::where('status', 'Ditolak')->get()->count();

        return view('pages.Dashboard.DashboardAdmin', ["permohonan" => $permohonan, "permohonanTerima" => $permohonanTerima, "jmlPermohonan" => $jmlPermohonan, 'jmlPermohonanDisetujui' => $jmlPermohonanDisetujui, 'jmlPermohonanDitolak' => $jmlPermohonanDitolak, 'jmlBatal' => $jmlBatal, 'jmlDiProses' => $jmlDiProses, 'jmlTotalPengajuan' => $jmlTotalPengajuan]);
    }

    public function searchNameAdmin(Request $request)
    {

        // $cari = $request->searchName;

        $permohonan = DB::table('users')
            ->join('permohonan_cuti', 'users.id', '=', 'permohonan_cuti.user_id')
            ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
            ->select('users.name', 'permohonan_cuti.id', 'permohonan_cuti.alasan_cuti', 'permohonan_cuti.tgl_mulai', 'permohonan_cuti.tgl_akhir', 'permohonan_cuti.status', 'permohonan_cuti.ket_tolak', 'permohonan_cuti.durasi_cuti', 'permohonan_cuti.tgl_memohon', 'permohonan_cuti.warna_cuti', 'karyawan.divisi', 'users.role')
            ->orderBy('permohonan_cuti.created_at', "desc")
            ->where('users.name', 'LIKE', '%' . $request->searchName . '%')
            // ->limit(5)
            ->paginate(10);

        $permohonanTerima = DB::table('users')
            ->join('permohonan_cuti', 'users.id', '=', 'permohonan_cuti.user_id')
            ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
            ->select('users.name', 'karyawan.divisi', 'permohonan_cuti.id', 'permohonan_cuti.alasan_cuti', 'permohonan_cuti.tgl_mulai', 'permohonan_cuti.tgl_akhir', 'permohonan_cuti.status', 'permohonan_cuti.ket_tolak', 'permohonan_cuti.durasi_cuti', 'permohonan_cuti.tgl_memohon', 'permohonan_cuti.warna_cuti')
            ->where(function ($query) {
                $query->where('permohonan_cuti.status', 'Diterima');
                $query->orWhere('permohonan_cuti.status', 'Di Ka.Divisi');
                $query->orWhere('permohonan_cuti.status', 'Di Direktur');
            })
            // ->limit(5)
            ->get();

        $jmlPermohonan = Permohonan_Cuti::where('status', 'Di Ka.Divisi')->get()->count();
        $jmlDiProses = Permohonan_Cuti::where('status', 'Di Direktur')->get()->count();
        $jmlTotalPengajuan = $jmlPermohonan + $jmlDiProses;
        $jmlBatal = Permohonan_Cuti::where('status', 'Dibatalkan')->get()->count();
        $jmlPermohonanDisetujui = Permohonan_Cuti::where('status', 'Diterima')->get()->count();
        $jmlPermohonanDitolak = Permohonan_Cuti::where('status', 'Ditolak')->get()->count();

        return view('pages.Dashboard.DashboardAdmin', ["permohonan" => $permohonan, "permohonanTerima" => $permohonanTerima, "jmlPermohonan" => $jmlPermohonan, 'jmlPermohonanDisetujui' => $jmlPermohonanDisetujui, 'jmlPermohonanDitolak' => $jmlPermohonanDitolak, 'jmlBatal' => $jmlBatal, 'jmlDiProses' => $jmlDiProses, 'jmlTotalPengajuan' => $jmlTotalPengajuan]);
    }

    public function changeStatus(Request $request)
    {

        $permohonanGet = DB::table('users')
            ->join('permohonan_cuti', 'users.id', '=', 'permohonan_cuti.user_id')
            ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
            ->select('users.name', 'permohonan_cuti.id', 'permohonan_cuti.alasan_cuti', 'permohonan_cuti.tgl_mulai', 'permohonan_cuti.tgl_akhir', 'permohonan_cuti.status', 'permohonan_cuti.ket_tolak', 'permohonan_cuti.durasi_cuti', 'permohonan_cuti.tgl_memohon', 'permohonan_cuti.warna_cuti', 'karyawan.divisi', 'users.role');

        if ($request->namaStatus == "Di Ka.Divisi") {
            $permohonan = $permohonanGet
                ->where('permohonan_cuti.status', 'Di Ka.Divisi')
                ->orderBy('permohonan_cuti.created_at', "desc");
        } elseif ($request->namaStatus == "Diterima") {
            $permohonan = $permohonanGet
                ->where('permohonan_cuti.status', 'Diterima')
                ->orderBy('permohonan_cuti.created_at', "desc");
        } elseif ($request->namaStatus == "Di Direktur") {
            $permohonan = $permohonanGet
                ->where('permohonan_cuti.status', 'Di Direktur')
                ->orderBy('permohonan_cuti.created_at', "desc");
        } elseif ($request->namaStatus == "Dibatalkan") {
            $permohonan = $permohonanGet
                ->where('permohonan_cuti.status', 'Dibatalkan')
                ->orderBy('permohonan_cuti.created_at', "desc");
        } elseif ($request->namaStatus == "Ditolak") {
            $permohonan = $permohonanGet
                ->where('permohonan_cuti.status', 'Ditolak')
                ->orderBy('permohonan_cuti.created_at', "desc");
        } elseif ($request->namaStatus == "Semua") {
            $permohonan = DB::table('users')
                ->join('permohonan_cuti', 'users.id', '=', 'permohonan_cuti.user_id')
                ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
                ->select('users.name', 'users.role', 'karyawan.divisi', 'permohonan_cuti.id', 'permohonan_cuti.alasan_cuti', 'permohonan_cuti.tgl_mulai', 'permohonan_cuti.tgl_akhir', 'permohonan_cuti.status', 'permohonan_cuti.ket_tolak', 'permohonan_cuti.durasi_cuti', 'permohonan_cuti.tgl_memohon')
                // ->where('permohonan_cuti.status','Di Ka.Divisi')
                ->orderBy('permohonan_cuti.created_at', "desc");
            // ->limit(5)
        }

        $permohonanFinal = $permohonan->paginate(10);

        $permohonanTerima = DB::table('users')
            ->join('permohonan_cuti', 'users.id', '=', 'permohonan_cuti.user_id')
            ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
            ->select('users.name', 'karyawan.divisi', 'permohonan_cuti.id', 'permohonan_cuti.alasan_cuti', 'permohonan_cuti.tgl_mulai', 'permohonan_cuti.tgl_akhir', 'permohonan_cuti.status', 'permohonan_cuti.ket_tolak', 'permohonan_cuti.durasi_cuti', 'permohonan_cuti.tgl_memohon', 'permohonan_cuti.warna_cuti')
            ->where(function ($query) {
                $query->where('permohonan_cuti.status', 'Diterima');
                $query->orWhere('permohonan_cuti.status', 'Di Ka.Divisi');
                $query->orWhere('permohonan_cuti.status', 'Di Direktur');
            })
            // ->limit(5)
            ->get();

        $jmlPermohonan = Permohonan_Cuti::where('status', 'Di Ka.Divisi')->get()->count();
        $jmlDiProses = Permohonan_Cuti::where('status', 'Di Direktur')->get()->count();
        $jmlTotalPengajuan = $jmlPermohonan + $jmlDiProses;
        $jmlBatal = Permohonan_Cuti::where('status', 'Dibatalkan')->get()->count();
        $jmlPermohonanDisetujui = Permohonan_Cuti::where('status', 'Diterima')->get()->count();
        $jmlPermohonanDitolak = Permohonan_Cuti::where('status', 'Ditolak')->get()->count();

        return view('pages.Dashboard.DashboardAdmin', ["permohonan" => $permohonanFinal, "permohonanTerima" => $permohonanTerima, "jmlPermohonan" => $jmlPermohonan, 'jmlPermohonanDisetujui' => $jmlPermohonanDisetujui, 'jmlPermohonanDitolak' => $jmlPermohonanDitolak, 'jmlBatal' => $jmlBatal, 'jmlDiProses' => $jmlDiProses, 'jmlTotalPengajuan' => $jmlTotalPengajuan]);
    }


    public function indexKadivisi()
    {
        $permohonan = DB::table('users')
            ->join('permohonan_cuti', 'users.id', '=', 'permohonan_cuti.user_id')
            ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
            ->select('users.name', 'permohonan_cuti.id', 'permohonan_cuti.alasan_cuti', 'permohonan_cuti.tgl_mulai', 'permohonan_cuti.tgl_akhir', 'permohonan_cuti.status', 'permohonan_cuti.ket_tolak', 'permohonan_cuti.durasi_cuti', 'permohonan_cuti.tgl_memohon', 'permohonan_cuti.warna_cuti', 'karyawan.divisi', 'users.role')
            ->orderBy('permohonan_cuti.created_at', "desc");
        // ->where('permohonan_cuti.status','pending')
        // ->limit(5)
        // ->get();
        $permohonanTerima = DB::table('users')
            ->join('permohonan_cuti', 'users.id', '=', 'permohonan_cuti.user_id')
            ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
            ->select('users.name', 'karyawan.divisi', 'permohonan_cuti.id', 'permohonan_cuti.alasan_cuti', 'permohonan_cuti.tgl_mulai', 'permohonan_cuti.tgl_akhir', 'permohonan_cuti.status', 'permohonan_cuti.ket_tolak', 'permohonan_cuti.durasi_cuti', 'permohonan_cuti.tgl_memohon', 'permohonan_cuti.warna_cuti')
            ->where(function ($query) {
                $query->where('permohonan_cuti.status', 'Diterima');
                $query->orWhere('permohonan_cuti.status', 'Di Ka.Divisi');
                $query->orWhere('permohonan_cuti.status', 'Di Direktur');
            });
        // ->limit(5)

        // ->limit(5)
        // ->get();

        $jmlPermohonan = Permohonan_Cuti::where('status', 'Di Ka.Divisi')->get()->count();
        $jmlDiProses = Permohonan_Cuti::where('status', 'Di Direktur')->get()->count();
        $jmlBatal = Permohonan_Cuti::where('status', 'Dibatalkan')->get()->count();
        $jmlPermohonanDisetujui = Permohonan_Cuti::where('status', 'Diterima')->get()->count();
        $jmlPermohonanDitolak = Permohonan_Cuti::where('status', 'Ditolak')->get()->count();

        $permohonanDivisi = $permohonan->where('karyawan.divisi', Auth::user()->karyawan->divisi)->paginate(10);


        $calendarAdmin = $permohonanTerima->get();

        $calendarDivisi = $permohonanTerima->where('karyawan.divisi', Auth::user()->karyawan->divisi)->get();

        return view('pages.Dashboard.DashboardKaDivisi', ["permohonan" => $permohonan, "permohonanDivisi" => $permohonanDivisi, "permohonanTerima" => $calendarAdmin, "calendarDivisi" => $calendarDivisi, "jmlPermohonan" => $jmlPermohonan, 'jmlPermohonanDisetujui' => $jmlPermohonanDisetujui, 'jmlPermohonanDitolak' => $jmlPermohonanDitolak, 'jmlBatal' => $jmlBatal, 'jmlDiProses' => $jmlDiProses]);
    }

    public function searchNameKaDivisi(Request $request)
    {

        // $cari = $request->searchName;

        $permohonan = DB::table('users')
            ->join('permohonan_cuti', 'users.id', '=', 'permohonan_cuti.user_id')
            ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
            ->select('users.name', 'permohonan_cuti.id', 'permohonan_cuti.alasan_cuti', 'permohonan_cuti.tgl_mulai', 'permohonan_cuti.tgl_akhir', 'permohonan_cuti.status', 'permohonan_cuti.ket_tolak', 'permohonan_cuti.durasi_cuti', 'permohonan_cuti.tgl_memohon', 'permohonan_cuti.warna_cuti', 'karyawan.divisi', 'users.role')
            ->orderBy('permohonan_cuti.created_at', "desc")
            ->where('users.name', 'LIKE', '%' . $request->searchName . '%');
        // ->limit(5)
        // ->paginate(10);
        // ->where('permohonan_cuti.status','pending')
        // ->limit(5)
        // ->get();
        $permohonanTerima = DB::table('users')
            ->join('permohonan_cuti', 'users.id', '=', 'permohonan_cuti.user_id')
            ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
            ->select('users.name', 'karyawan.divisi', 'permohonan_cuti.id', 'permohonan_cuti.alasan_cuti', 'permohonan_cuti.tgl_mulai', 'permohonan_cuti.tgl_akhir', 'permohonan_cuti.status', 'permohonan_cuti.ket_tolak', 'permohonan_cuti.durasi_cuti', 'permohonan_cuti.tgl_memohon', 'permohonan_cuti.warna_cuti')
            ->where(function ($query) {
                $query->where('permohonan_cuti.status', 'Diterima');
                $query->orWhere('permohonan_cuti.status', 'Di Ka.Divisi');
                $query->orWhere('permohonan_cuti.status', 'Di Direktur');
            });
        // ->limit(5)
        // ->get();

        $jmlPermohonan = Permohonan_Cuti::where('status', 'Di Ka.Divisi')->get()->count();
        $jmlDiProses = Permohonan_Cuti::where('status', 'Di Direktur')->get()->count();
        $jmlBatal = Permohonan_Cuti::where('status', 'Dibatalkan')->get()->count();
        $jmlPermohonanDisetujui = Permohonan_Cuti::where('status', 'Diterima')->get()->count();
        $jmlPermohonanDitolak = Permohonan_Cuti::where('status', 'Ditolak')->get()->count();

        $permohonanDivisi = $permohonan->where('karyawan.divisi', Auth::user()->karyawan->divisi)->paginate(10);;


        $calendarAdmin = $permohonanTerima->get();

        $calendarDivisi = $permohonanTerima->where('karyawan.divisi', Auth::user()->karyawan->divisi)->get();

        return view('pages.Dashboard.DashboardKaDivisi', ["permohonan" => $permohonan, "permohonanDivisi" => $permohonanDivisi, "permohonanTerima" => $calendarAdmin, "calendarDivisi" => $calendarDivisi, "jmlPermohonan" => $jmlPermohonan, 'jmlPermohonanDisetujui' => $jmlPermohonanDisetujui, 'jmlPermohonanDitolak' => $jmlPermohonanDitolak, 'jmlBatal' => $jmlBatal, 'jmlDiProses' => $jmlDiProses]);
    }

    public function changeStatusKaDivisi(Request $request)
    {

        $permohonanGet = DB::table('users')
            ->join('permohonan_cuti', 'users.id', '=', 'permohonan_cuti.user_id')
            ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
            ->select('users.name', 'permohonan_cuti.id', 'permohonan_cuti.alasan_cuti', 'permohonan_cuti.tgl_mulai', 'permohonan_cuti.tgl_akhir', 'permohonan_cuti.status', 'permohonan_cuti.ket_tolak', 'permohonan_cuti.durasi_cuti', 'permohonan_cuti.tgl_memohon', 'permohonan_cuti.warna_cuti', 'karyawan.divisi', 'users.role')
            ->orderBy('permohonan_cuti.created_at', "desc");

        if ($request->namaStatus == "Di Ka.Divisi") {
            $permohonan = $permohonanGet
                ->where('permohonan_cuti.status', 'Di Ka.Divisi')
                ->orderBy('permohonan_cuti.created_at', "desc");
        } elseif ($request->namaStatus == "Diterima") {
            $permohonan = $permohonanGet
                ->where('permohonan_cuti.status', 'Diterima')
                ->orderBy('permohonan_cuti.created_at', "desc");
        } elseif ($request->namaStatus == "Di Direktur") {
            $permohonan = $permohonanGet
                ->where('permohonan_cuti.status', 'Di Direktur')
                ->orderBy('permohonan_cuti.created_at', "desc");
        } elseif ($request->namaStatus == "Dibatalkan") {
            $permohonan = $permohonanGet
                ->where('permohonan_cuti.status', 'Dibatalkan')
                ->orderBy('permohonan_cuti.created_at', "desc");
        } elseif ($request->namaStatus == "Ditolak") {
            $permohonan = $permohonanGet
                ->where('permohonan_cuti.status', 'Ditolak')
                ->orderBy('permohonan_cuti.created_at', "desc");
        } elseif ($request->namaStatus == "Semua") {
            $permohonan = DB::table('users')
                ->join('permohonan_cuti', 'users.id', '=', 'permohonan_cuti.user_id')
                ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
                ->select('users.name', 'permohonan_cuti.id', 'permohonan_cuti.alasan_cuti', 'permohonan_cuti.tgl_mulai', 'permohonan_cuti.tgl_akhir', 'permohonan_cuti.status', 'permohonan_cuti.ket_tolak', 'permohonan_cuti.durasi_cuti', 'permohonan_cuti.tgl_memohon', 'permohonan_cuti.warna_cuti', 'karyawan.divisi', 'users.role');
            // ->limit(5)

        }
        $permohonanTerima = DB::table('users')
            ->join('permohonan_cuti', 'users.id', '=', 'permohonan_cuti.user_id')
            ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
            ->select('users.name', 'karyawan.divisi', 'permohonan_cuti.id', 'permohonan_cuti.alasan_cuti', 'permohonan_cuti.tgl_mulai', 'permohonan_cuti.tgl_akhir', 'permohonan_cuti.status', 'permohonan_cuti.ket_tolak', 'permohonan_cuti.durasi_cuti', 'permohonan_cuti.tgl_memohon', 'permohonan_cuti.warna_cuti')
            ->where(function ($query) {
                $query->where('permohonan_cuti.status', 'Diterima');
                $query->orWhere('permohonan_cuti.status', 'Di Ka.Divisi');
                $query->orWhere('permohonan_cuti.status', 'Di Direktur');
            });
        // ->limit(5)
        // ->get();

        $jmlPermohonan = Permohonan_Cuti::where('status', 'Di Ka.Divisi')->get()->count();
        $jmlDiProses = Permohonan_Cuti::where('status', 'Di Direktur')->get()->count();
        $jmlBatal = Permohonan_Cuti::where('status', 'Dibatalkan')->get()->count();
        $jmlPermohonanDisetujui = Permohonan_Cuti::where('status', 'Diterima')->get()->count();
        $jmlPermohonanDitolak = Permohonan_Cuti::where('status', 'Ditolak')->get()->count();

        $permohonanDivisi = $permohonan->where('karyawan.divisi', Auth::user()->karyawan->divisi)->paginate(10);


        $calendarAdmin = $permohonanTerima->get();

        $calendarDivisi = $permohonanTerima->where('karyawan.divisi', Auth::user()->karyawan->divisi)->get();

        return view('pages.Dashboard.DashboardKaDivisi', ["permohonan" => $permohonan, "permohonanDivisi" => $permohonanDivisi, "permohonanTerima" => $calendarAdmin, "calendarDivisi" => $calendarDivisi, "jmlPermohonan" => $jmlPermohonan, 'jmlPermohonanDisetujui' => $jmlPermohonanDisetujui, 'jmlPermohonanDitolak' => $jmlPermohonanDitolak, 'jmlBatal' => $jmlBatal, 'jmlDiProses' => $jmlDiProses]);
    }


    public function show()
    {
        $id = Auth::user()->id;
        $permohonan = DB::table('users')
            ->join('permohonan_cuti', 'users.id', '=', 'permohonan_cuti.user_id')
            ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
            ->select('users.name', 'permohonan_cuti.id', 'permohonan_cuti.alasan_cuti', 'permohonan_cuti.tgl_mulai', 'permohonan_cuti.tgl_akhir', 'permohonan_cuti.status', 'permohonan_cuti.ket_tolak', 'permohonan_cuti.durasi_cuti', 'permohonan_cuti.tgl_memohon', 'karyawan.jumlah_cuti')
            ->where('users.id', $id)
            ->orderBy('permohonan_cuti.created_at', "desc")
            // ->limit(5)
            ->paginate(10);

        $permohonanTerima = DB::table('users')
            ->join('permohonan_cuti', 'users.id', '=', 'permohonan_cuti.user_id')
            ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
            ->select('users.name', 'karyawan.divisi', 'permohonan_cuti.id', 'permohonan_cuti.alasan_cuti', 'permohonan_cuti.tgl_mulai', 'permohonan_cuti.tgl_akhir', 'permohonan_cuti.status', 'permohonan_cuti.ket_tolak', 'permohonan_cuti.durasi_cuti', 'permohonan_cuti.tgl_memohon')
            ->where('permohonan_cuti.status', 'Diterima');

        $getRagneTanggal = DB::table('users')
            ->join('permohonan_cuti', 'users.id', '=', 'permohonan_cuti.user_id')
            ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
            ->select('users.name', 'permohonan_cuti.tgl_mulai', 'permohonan_cuti.tgl_akhir', 'karyawan.divisi', 'permohonan_cuti.id', 'permohonan_cuti.alasan_cuti', 'permohonan_cuti.tgl_mulai', 'permohonan_cuti.tgl_akhir', 'permohonan_cuti.status', 'permohonan_cuti.ket_tolak', 'permohonan_cuti.durasi_cuti', 'permohonan_cuti.tgl_memohon', 'permohonan_cuti.warna_cuti')
            // ->where(
            //     function($query) {
            //         return $query
            //             ->where('permohonan_cuti.status','Diterima')
            //             ->orWhere('permohonan_cuti.status','Di Ka.Divisi');
            //     })
            ->where(function ($query) {
                $query->where('permohonan_cuti.status', 'Diterima');
                $query->orWhere('permohonan_cuti.status', 'Di Ka.Divisi');
                $query->orWhere('permohonan_cuti.status', 'Di Direktur');
            })
            ->where('karyawan.divisi', Auth::user()->karyawan->divisi)
            ->get();

        // $getRagneTanggal = '2022-10-25';


        $sisaCuti = DB::table('karyawan')->where('user_id', $id)->value('jumlah_cuti');
        $jmlPermohonanDisetujui = Permohonan_Cuti::Where('status', 'disetujui')->where('user_id', $id)->get()->count();
        $jmlPermohonanDitolak = Permohonan_Cuti::where('status', 'ditolak')->where('user_id', $id)->get()->count();

        $calendarAdmin = $permohonanTerima->get();

        $calendarDivisi = $permohonanTerima->where('karyawan.divisi', Auth::user()->karyawan->divisi)->get();

        return view('pages.Dashboard.DashboardKaryawan', ["permohonan" => $permohonan, 'sisa_cuti' => $sisaCuti, 'jmlPermohonanDisetujui' => $jmlPermohonanDisetujui, "calendarDivisi" => $calendarDivisi, 'jmlPermohonanDitolak' => $jmlPermohonanDitolak, 'getRagneTanggal' => $getRagneTanggal]);
    }

    public function destroy(Request $request)
    {

        $durasiCuti = DB::table('permohonan_cuti')
            ->where('id', $request->custId)
            ->value('durasi_cuti');

        $getUserId = DB::table('permohonan_cuti')
            ->where('id', $request->custId)
            ->value('user_id');

        $getJumlahCuti = DB::table('karyawan')
            ->where('user_id', $getUserId)
            ->value('jumlah_cuti');

        $tambahJmlCuti = $getJumlahCuti + $durasiCuti;

        DB::table('karyawan')
            ->where('user_id', $getUserId)
            ->update(['jumlah_cuti' => $tambahJmlCuti]);


        $permohonan = DB::table('permohonan_cuti')
            ->where('id', $request->custId);

        $permohonan->delete();

        return redirect()->route('admin.dashboard')->with(['success' => 'Pengajuan Cuti yang Dipilih Berhasil Dihapus!']);
    }
}
