<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Permohonan_Cuti;
use App\Models\Karyawan;
use Illuminate\Support\Facades\DB;;

use Illuminate\Support\Facades\Auth;
use PDF;
use Illuminate\Support\Facades\DateTime;




class PermohonanCutiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role === "Kepala Divisi") {
            $permohonanDivisi = DB::table('users')
                ->join('permohonan_cuti', 'users.id', '=', 'permohonan_cuti.user_id')
                ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
                ->select('permohonan_cuti.id', 'users.name', 'permohonan_cuti.alasan_cuti', 'permohonan_cuti.tgl_mulai', 'permohonan_cuti.tgl_memohon', 'permohonan_cuti.durasi_cuti', 'permohonan_cuti.tgl_akhir', 'permohonan_cuti.status', 'permohonan_cuti.ket_tolak')
                ->where('permohonan_cuti.status', '=', 'Di Ka.Divisi')
                ->orderBy('permohonan_cuti.created_at', "desc");
            // ->get();

            $permohonan = $permohonanDivisi->where('karyawan.divisi', Auth::user()->karyawan->divisi)->paginate(10);

            $permohonanTerima = DB::table('users')
                ->join('permohonan_cuti', 'users.id', '=', 'permohonan_cuti.user_id')
                ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
                ->select('users.name', 'karyawan.divisi', 'permohonan_cuti.id', 'permohonan_cuti.alasan_cuti', 'permohonan_cuti.tgl_mulai', 'permohonan_cuti.tgl_akhir', 'permohonan_cuti.status', 'permohonan_cuti.ket_tolak', 'permohonan_cuti.durasi_cuti', 'permohonan_cuti.tgl_memohon', 'permohonan_cuti.warna_cuti')
                ->where('permohonan_cuti.status', 'Diterima')
                ->get();
        } elseif (Auth::user()->role === "Leader") {
            $permohonan = DB::table('users')
                ->join('permohonan_cuti', 'users.id', '=', 'permohonan_cuti.user_id')
                ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
                ->select('permohonan_cuti.id', 'users.name', 'permohonan_cuti.alasan_cuti', 'permohonan_cuti.tgl_mulai', 'permohonan_cuti.tgl_memohon', 'permohonan_cuti.durasi_cuti', 'permohonan_cuti.tgl_akhir', 'permohonan_cuti.status', 'permohonan_cuti.ket_tolak')
                ->orderBy('permohonan_cuti.created_at', "desc")
                ->where('permohonan_cuti.status', 'Di Direktur')
                ->paginate(10);

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
        }

        return view('pages.permohonanCuti.index', ['permohonan' => $permohonan, 'permohonanTerima' => $permohonanTerima]);
    }

    public function isiSurat(Request $request)
    {
        $dataSurat = DB::table('users')
            ->join('permohonan_cuti', 'users.id', '=', 'permohonan_cuti.user_id')
            ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
            ->select('users.name', 'users.nik', 'karyawan.jabatan', 'karyawan.divisi', 'permohonan_cuti.id', 'permohonan_cuti.user_id', 'permohonan_cuti.status', 'permohonan_cuti.durasi_cuti', 'permohonan_cuti.alasan_cuti', 'permohonan_cuti.tgl_mulai', 'permohonan_cuti.tgl_akhir', 'users.no_telpon',)
            ->where('permohonan_cuti.id', $request->custId)
            ->get();

        $ifOneDayMulai = DB::table('permohonan_cuti')
            ->where('id', $request->custId)
            ->value('tgl_mulai');

        $ifOneDayAkhir = DB::table('permohonan_cuti')
            ->where('id', $request->custId)
            ->value('tgl_akhir');

        $getHRD = DB::table('users')
            ->where('role', 'HRD')
            ->value('name');

        if ($request->roleKaryawan == 'karyawan') {
            $getAtasan = DB::table('users')
                ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
                ->where('users.role', 'Kepala Divisi')
                ->where('karyawan.divisi', $request->divisiKaryawan)
                ->value('users.name');
        } else {
            $getAtasan = DB::table('users')
                ->where('users.role', 'Leader')
                ->value('users.name');
        }

        $tanggalCuti = Permohonan_Cuti::find($request->custId);
        $hariMulai = $tanggalCuti->tgl_mulai->isoFormat('dddd');
        $hariAkhir = $tanggalCuti->tgl_akhir->isoFormat('dddd');
        $tglMulai = $tanggalCuti->tgl_mulai->isoFormat('D MMMM Y');
        $tglAkhir = $tanggalCuti->tgl_akhir->isoFormat('D MMMM Y');

        $hari_mulai = $tanggalCuti->tgl_mulai->isoFormat('D');
        $hari_akhir = $tanggalCuti->tgl_akhir->isoFormat('D');

        $bulanLaporan_awalBulan = $tanggalCuti->tgl_mulai->isoFormat('MMMM');

        $bulanLaporan_awal = $tanggalCuti->tgl_mulai->isoFormat('MMMM Y');
        $bulanLaporan_akhir = $tanggalCuti->tgl_akhir->isoFormat('MMMM Y');


        $hariIni = Carbon::now()->isoFormat('D MMMM Y');

        $pdf = PDF::loadview('pages.permohonanCuti.surat', ['dataSurat' => $dataSurat, 'getHRD' => $getHRD, 'hariIni' => $hariIni, 'hariMulai' => $hariMulai, 'hariAkhir' => $hariAkhir, 'tglMulai' => $tglMulai, 'tglAkhir' => $tglAkhir, 'getAtasan' => $getAtasan, 'ifOneDayMulai' => $ifOneDayMulai, 'ifOneDayAkhir' => $ifOneDayAkhir, 'hari_mulai' => $hari_mulai, 'hari_akhir' => $hari_akhir, 'bulanLaporan_awal' => $bulanLaporan_awal, 'bulanLaporan_akhir' => $bulanLaporan_akhir, "bulanLaporan_awalBulan" => $bulanLaporan_awalBulan])->setpaper('A4', 'potrait');
        return $pdf->stream('Surat_Cuti_Booble.id.pdf');
    }

    public function laporanCuti(Request $request)
    {

        $dates = explode(' - ', $request->dateRangeReport);
        $start_date = Carbon::parse($dates[0])->toDateString();
        $end_date = Carbon::parse($dates[1])->toDateString();

        $get_start_date = Carbon::parse($dates[0]);
        $get_end_date = Carbon::parse($dates[1]);

        $tglMulai = date_create($get_start_date);
        $tglAkhir = date_create($get_end_date);
        $durasi = date_diff($tglAkhir, $tglMulai);

        $jumlah_durasi = $durasi->days;

        $bulanLaporan = $get_start_date->isoFormat('MMMM Y');

        $bulanLaporan_mulai = $get_start_date->isoFormat('MMMM Y');
        $bulanLaporan_akhir = $get_end_date->isoFormat('MMMM Y');

        $bedaBulanLaporan_mulai = $get_start_date->isoFormat('D MMMM Y');
        $bedaBulanLapora_akhir = $get_end_date->isoFormat('D MMMM Y');

        $hari_mulai = $get_start_date->isoFormat('D');
        $hari_akhir = $get_end_date->isoFormat('D');

        $permohonan = DB::table('users')
            ->join('permohonan_cuti', 'users.id', '=', 'permohonan_cuti.user_id')
            ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
            ->select('users.name', 'permohonan_cuti.id', 'permohonan_cuti.alasan_cuti', 'permohonan_cuti.tgl_mulai', 'permohonan_cuti.tgl_akhir', 'permohonan_cuti.status', 'permohonan_cuti.ket_tolak', 'permohonan_cuti.durasi_cuti', 'permohonan_cuti.tgl_memohon', 'permohonan_cuti.warna_cuti', 'karyawan.divisi', 'karyawan.jabatan', 'karyawan.jumlah_cuti', 'users.role')
            ->orderBy('permohonan_cuti.created_at', "desc")
            ->whereBetween('permohonan_cuti.tgl_mulai', [$start_date, $end_date])
            ->where('permohonan_cuti.status', 'Diterima')
            // ->limit(5)
            ->get();

        $pdf = PDF::loadview('pages.permohonanCuti.laporan', ["permohonan" => $permohonan, "bulanLaporan" => $bulanLaporan, "bulanLaporan_mulai" => $bulanLaporan_mulai, "bulanLaporan_akhir" => $bulanLaporan_akhir, "bedaBulanLaporan_mulai" => $bedaBulanLaporan_mulai, "bedaBulanLapora_akhir" => $bedaBulanLapora_akhir, "jumlah_durasi" => $jumlah_durasi, "hari_mulai" => $hari_mulai, "hari_akhir" => $hari_akhir])->setpaper('A4', 'landscape');
        return $pdf->stream('Surat_Cuti_Booble_id.pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $id = Auth::user()->id;
        $permohonan = DB::table('karyawan')
            ->join('permohonan_cuti', 'karyawan.id', '=', 'permohonan_cuti.user_id')
            ->select('karyawan.jumlah_cuti')
            ->where('karyawan.user_id', 'id')
            ->get();

        $data = DB::table('karyawan')->select('jumlah_cuti')->where('user_id', $id)->get();

        $sisaCuti = $data[0]->jumlah_cuti;

        $tglMulai = date_create($request->tgl_mulai);
        $tglAkhir = date_create($request->tgl_akhir);
        $durasi = date_diff($tglAkhir, $tglMulai);

        $jumlahCuti = $sisaCuti - $durasi->days;

        $is_weekend = 0;
        $tglMulaiC = strtotime($request->tgl_mulai);
        $tglAkhirC = strtotime($request->tgl_akhir);
        while (date("Y-m-d", $tglMulaiC) != date("Y-m-d", $tglAkhirC)) {
            $day = date("w", $tglMulaiC);
            if ($day == 0) {
                $is_weekend = 1;
            }
            $tglMulaiC = strtotime(date("Y-m-d", $tglMulaiC) . "+1 day");
        }

        if ($jumlahCuti < 0) {
            return redirect()->route('karyawan.dashboard')->with(['message' => 'Maaf anda tidak bisa mengajukan cuti karena sisa cuti anda sudah habis']);
        } elseif ($durasi->format('%d') > 4) {
            return redirect()->route('karyawan.dashboard')->with(['message' => 'Maaf anda tidak bisa mengajukan cuti karena durasi cuti maksimal 4 hari sekali pangajuan']);
        } elseif ($is_weekend == 1) {

            if (Auth::user()->role === "karyawan") {
                $totalCuti = $durasi->days - 0;
                DB::table('permohonan_cuti')->insert([
                    'user_id' => Auth::id(),
                    'alasan_cuti' => $request->alasan_cuti,
                    'tgl_mulai' => $request->tgl_mulai,
                    'tgl_akhir' => $request->tgl_akhir,
                    'durasi_cuti' => $totalCuti,
                    'warna_cuti' => "#929090",
                    'tgl_memohon' => Carbon::now(),
                    'status' => 'Di Ka.Divisi',
                    'created_at' => Carbon::now()->toDateTimeString()
                ]);


                //Pesan untuk karyawan

                $getNama = DB::table('users')
                    ->where('id', $id)
                    ->value('name');
                $getDivisi = DB::table('users')
                    ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
                    ->where('users.id', $id)
                    ->value('karyawan.divisi');
                $getJabatan = DB::table('users')
                    ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
                    ->where('users.id', $id)
                    ->value('karyawan.jabatan');

                $getPesan = "*Pengajuan* *Cuti* *Karyawan*" . "\n\nNama: " . $getNama . "\nDivisi: " . $getDivisi . "\nJabatan: " . $getJabatan . "\nMulai Cuti: " . $request->tgl_mulai . "\nAkhir Cuti: " . $request->tgl_akhir . "\nAlasan Cuti: " . $request->alasan_cuti . "\n\nMohon mengecek web pengajuan cuti segera di www.cuti.booblestudio.com";

                $getTelp = DB::table('users')
                    ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
                    ->where('users.role', 'Kepala Divisi')
                    ->where('karyawan.divisi', Auth::user()->karyawan->divisi)
                    ->value('users.no_telpon');

                //Pesan untuk HRD

                $getPesanHRD = "*Pengajuan* *Cuti* *Karyawan*" . "\n\nNama: " . $getNama . "\nDivisi: " . $getDivisi . "\nJabatan: " . $getJabatan . "\nMulai Cuti: " . $request->tgl_mulai . "\nAkhir Cuti: " . $request->tgl_akhir . "\nAlasan Cuti: " . $request->alasan_cuti . "\n\nMohon mengecek web pengajuan cuti segera di www.cuti.booblestudio.com";

                $getTelpHRD = DB::table('users')
                    ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
                    ->where('users.role', 'HRD')
                    ->value('users.no_telpon');

                function send_wa($telp, $pesan)
                {
                    // METHOD POST
                    // Pastikan phone menggunakan kode negara 62 di depannya
                    $phone = str_replace('08', '628', $telp);
                    $message = $pesan;

                    $apikey = '51Uy5loPoLC2FAuiAYhypAhv4IqU6xOy';
                    $url = 'https://api.wanotif.id/v1/send';

                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, $url);
                    curl_setopt($curl, CURLOPT_HEADER, 0);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
                    curl_setopt($curl, CURLOPT_POST, 1);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, array(
                        'Apikey'    => $apikey,
                        'Phone'     => $phone,
                        'Message'   => $message,
                    ));
                    $response = curl_exec($curl);
                    curl_close($curl);

                    $res = json_decode($response, TRUE);

                    if ($res['wanotif']['status'] != 'sent') {
                        $userkey = '3efc3303a58c';
                        $passkey = 'kp6iswm84z';
                        $telepon = $telp;
                        $message = $pesan;

                        $url = 'https://console.zenziva.net/wareguler/api/sendWA/';
                        $curlHandle = curl_init();
                        curl_setopt($curlHandle, CURLOPT_URL, $url);
                        curl_setopt($curlHandle, CURLOPT_HEADER, 0);
                        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
                        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
                        curl_setopt($curlHandle, CURLOPT_TIMEOUT, 30);
                        curl_setopt($curlHandle, CURLOPT_POST, 1);
                        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, array(
                            'userkey' => $userkey,
                            'passkey' => $passkey,
                            'to' => $telepon,
                            'message' => $message
                        ));
                        $response = json_decode(curl_exec($curlHandle), true);
                        curl_close($curlHandle);
                    }

                    $resulte = $res['wanotif']['status'];

                    return $resulte;
                }

                send_wa($getTelp, $getPesan);

                send_wa($getTelpHRD, $getPesanHRD);

                return redirect()->route('karyawan.dashboard')->with(['success' => 'Berhasil Mengajukan Permohonan Cuti']);
            } else {
                $totalCuti = $durasi->days - 0;
                DB::table('permohonan_cuti')->insert([
                    'user_id' => Auth::id(),
                    'alasan_cuti' => $request->alasan_cuti,
                    'tgl_mulai' => $request->tgl_mulai,
                    'tgl_akhir' => $request->tgl_akhir,
                    'durasi_cuti' => $totalCuti,
                    'warna_cuti' => "#6900c7",
                    'tgl_memohon' => Carbon::now(),
                    'status' => 'Di Direktur',
                    'created_at' => Carbon::now()->toDateTimeString()
                ]);

                //Pesan untuk karyawan

                $getNama = DB::table('users')
                    ->where('id', $id)
                    ->value('name');
                $getDivisi = DB::table('users')
                    ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
                    ->where('users.id', $id)
                    ->value('karyawan.divisi');
                $getJabatan = DB::table('users')
                    ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
                    ->where('users.id', $id)
                    ->value('karyawan.jabatan');

                $getPesan = "*Pengajuan* *Cuti* *Karyawan*" . "\n\nNama: " . $getNama . "\nDivisi: " . $getDivisi . "\nJabatan: " . $getJabatan . "\nMulai Cuti: " . $request->tgl_mulai . "\nAkhir Cuti: " . $request->tgl_akhir . "\nAlasan Cuti: " . $request->alasan_cuti . "\n\nMohon mengecek web pengajuan cuti segera di www.cuti.booblestudio.com";

                $getTelp = DB::table('users')
                    ->where('role', 'Leader')
                    ->value('no_telpon');

                //Pesan untuk HRD

                $getPesanHRD = "*Pengajuan* *Cuti* *Karyawan*" . "\n\nNama: " . $getNama . "\nDivisi: " . $getDivisi . "\nJabatan: " . $getJabatan . "\nMulai Cuti: " . $request->tgl_mulai . "\nAkhir Cuti: " . $request->tgl_akhir . "\nAlasan Cuti: " . $request->alasan_cuti . "\n\nMohon mengecek web pengajuan cuti segera di www.cuti.booblestudio.com";

                $getTelpHRD = DB::table('users')
                    ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
                    ->where('users.role', 'HRD')
                    ->value('users.no_telpon');

                function send_wa($telp, $pesan)
                {
                    // METHOD POST
                    // Pastikan phone menggunakan kode negara 62 di depannya
                    $phone = str_replace('08', '628', $telp);
                    $message = $pesan;

                    $apikey = '51Uy5loPoLC2FAuiAYhypAhv4IqU6xOy';
                    $url = 'https://api.wanotif.id/v1/send';

                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, $url);
                    curl_setopt($curl, CURLOPT_HEADER, 0);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
                    curl_setopt($curl, CURLOPT_POST, 1);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, array(
                        'Apikey'    => $apikey,
                        'Phone'     => $phone,
                        'Message'   => $message,
                    ));
                    $response = curl_exec($curl);
                    curl_close($curl);

                    $res = json_decode($response, TRUE);

                    if ($res['wanotif']['status'] != 'sent') {
                        $userkey = '3efc3303a58c';
                        $passkey = 'kp6iswm84z';
                        $telepon = $telp;
                        $message = $pesan;

                        $url = 'https://console.zenziva.net/wareguler/api/sendWA/';
                        $curlHandle = curl_init();
                        curl_setopt($curlHandle, CURLOPT_URL, $url);
                        curl_setopt($curlHandle, CURLOPT_HEADER, 0);
                        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
                        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
                        curl_setopt($curlHandle, CURLOPT_TIMEOUT, 30);
                        curl_setopt($curlHandle, CURLOPT_POST, 1);
                        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, array(
                            'userkey' => $userkey,
                            'passkey' => $passkey,
                            'to' => $telepon,
                            'message' => $message
                        ));
                        $response = json_decode(curl_exec($curlHandle), true);
                        curl_close($curlHandle);
                    }

                    $resulte = $res['wanotif']['status'];

                    return $resulte;
                }

                send_wa($getTelp, $getPesan);

                send_wa($getTelpHRD, $getPesanHRD);


                return redirect()->route('karyawan.dashboard')->with(['success' => 'Berhasil Mengajukan Permohonan Cuti.']);
            }
        } else {
            if (Auth::user()->role === "karyawan") {
                $totalCuti = $durasi->days + 1;

                DB::table('permohonan_cuti')->insert([
                    'user_id' => Auth::id(),
                    'alasan_cuti' => $request->alasan_cuti,
                    'tgl_mulai' => $request->tgl_mulai,
                    'tgl_akhir' => $request->tgl_akhir,
                    'durasi_cuti' => $totalCuti,
                    'tgl_memohon' => Carbon::now(),
                    'warna_cuti' => "#929090",
                    'status' => 'Di Ka.Divisi',
                    'created_at' => Carbon::now()->toDateTimeString()
                ]);

                //Pesan untuk karyawan

                $getNama = DB::table('users')
                    ->where('id', $id)
                    ->value('name');
                $getDivisi = DB::table('users')
                    ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
                    ->where('users.id', $id)
                    ->value('karyawan.divisi');
                $getJabatan = DB::table('users')
                    ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
                    ->where('users.id', $id)
                    ->value('karyawan.jabatan');

                $getPesan = "*Pengajuan* *Cuti* *Karyawan*" . "\n\nNama: " . $getNama . "\nDivisi: " . $getDivisi . "\nJabatan: " . $getJabatan . "\nMulai Cuti: " . $request->tgl_mulai . "\nAkhir Cuti: " . $request->tgl_akhir . "\nAlasan Cuti: " . $request->alasan_cuti . "\n\nMohon mengecek web pengajuan cuti segera di www.cuti.booblestudio.com";

                $getTelp = DB::table('users')
                    ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
                    ->where('users.role', 'Kepala Divisi')
                    ->where('karyawan.divisi', Auth::user()->karyawan->divisi)
                    ->value('users.no_telpon');

                //Pesan untuk HRD

                $getPesanHRD = "*Pengajuan* *Cuti* *Karyawan*" . "\n\nNama: " . $getNama . "\nDivisi: " . $getDivisi . "\nJabatan: " . $getJabatan . "\nMulai Cuti: " . $request->tgl_mulai . "\nAkhir Cuti: " . $request->tgl_akhir . "\nAlasan Cuti: " . $request->alasan_cuti . "\n\nMohon mengecek web pengajuan cuti segera di www.cuti.booblestudio.com";

                $getTelpHRD = DB::table('users')
                    ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
                    ->where('users.role', 'HRD')
                    ->value('users.no_telpon');

                function send_wa($telp, $pesan)
                {
                    // METHOD POST
                    // Pastikan phone menggunakan kode negara 62 di depannya
                    $phone = str_replace('08', '628', $telp);
                    $message = $pesan;

                    $apikey = '51Uy5loPoLC2FAuiAYhypAhv4IqU6xOy';
                    $url = 'https://api.wanotif.id/v1/send';

                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, $url);
                    curl_setopt($curl, CURLOPT_HEADER, 0);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
                    curl_setopt($curl, CURLOPT_POST, 1);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, array(
                        'Apikey'    => $apikey,
                        'Phone'     => $phone,
                        'Message'   => $message,
                    ));
                    $response = curl_exec($curl);
                    curl_close($curl);

                    $res = json_decode($response, TRUE);

                    if ($res['wanotif']['status'] != 'sent') {
                        $userkey = '3efc3303a58c';
                        $passkey = 'kp6iswm84z';
                        $telepon = $telp;
                        $message = $pesan;

                        $url = 'https://console.zenziva.net/wareguler/api/sendWA/';
                        $curlHandle = curl_init();
                        curl_setopt($curlHandle, CURLOPT_URL, $url);
                        curl_setopt($curlHandle, CURLOPT_HEADER, 0);
                        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
                        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
                        curl_setopt($curlHandle, CURLOPT_TIMEOUT, 30);
                        curl_setopt($curlHandle, CURLOPT_POST, 1);
                        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, array(
                            'userkey' => $userkey,
                            'passkey' => $passkey,
                            'to' => $telepon,
                            'message' => $message
                        ));
                        $response = json_decode(curl_exec($curlHandle), true);
                        curl_close($curlHandle);
                    }

                    $resulte = $res['wanotif']['status'];

                    return $resulte;
                }

                send_wa($getTelp, $getPesan);

                send_wa($getTelpHRD, $getPesanHRD);

                return redirect()->route('karyawan.dashboard')->with(['success' => 'Berhasil Mengajukan Permohonan Cuti']);
            } else {
                $totalCuti = $durasi->days + 1;

                DB::table('permohonan_cuti')->insert([
                    'user_id' => Auth::id(),
                    'alasan_cuti' => $request->alasan_cuti,
                    'tgl_mulai' => $request->tgl_mulai,
                    'tgl_akhir' => $request->tgl_akhir,
                    'durasi_cuti' => $totalCuti,
                    'warna_cuti' => "#6900c7",
                    'tgl_memohon' => Carbon::now(),
                    'status' => 'Di Direktur',
                    'created_at' => Carbon::now()->toDateTimeString()
                ]);

                //Pesan untuk karyawan

                $getNama = DB::table('users')
                    ->where('id', $id)
                    ->value('name');
                $getDivisi = DB::table('users')
                    ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
                    ->where('users.id', $id)
                    ->value('karyawan.divisi');
                $getJabatan = DB::table('users')
                    ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
                    ->where('users.id', $id)
                    ->value('karyawan.jabatan');

                $getPesan = "*Pengajuan* *Cuti* *Karyawan*" . "\n\nNama: " . $getNama . "\nDivisi: " . $getDivisi . "\nJabatan: " . $getJabatan . "\nMulai Cuti: " . $request->tgl_mulai . "\nAkhir Cuti: " . $request->tgl_akhir . "\nAlasan Cuti: " . $request->alasan_cuti . "\n\nMohon mengecek web pengajuan cuti segera di www.cuti.booblestudio.com";

                $getTelp = DB::table('users')
                    ->where('role', 'Leader')
                    ->value('no_telpon');

                //Pesan untuk HRD

                $getPesanHRD = "*Pengajuan* *Cuti* *Karyawan*" . "\n\nNama: " . $getNama . "\nDivisi: " . $getDivisi . "\nJabatan: " . $getJabatan . "\nMulai Cuti: " . $request->tgl_mulai . "\nAkhir Cuti: " . $request->tgl_akhir . "\nAlasan Cuti: " . $request->alasan_cuti . "\n\nMohon mengecek web pengajuan cuti segera di www.cuti.booblestudio.com";

                $getTelpHRD = DB::table('users')
                    ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
                    ->where('users.role', 'HRD')
                    ->value('users.no_telpon');

                function send_wa($telp, $pesan)
                {
                    // METHOD POST
                    // Pastikan phone menggunakan kode negara 62 di depannya
                    $phone = str_replace('08', '628', $telp);
                    $message = $pesan;

                    $apikey = '51Uy5loPoLC2FAuiAYhypAhv4IqU6xOy';
                    $url = 'https://api.wanotif.id/v1/send';

                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, $url);
                    curl_setopt($curl, CURLOPT_HEADER, 0);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
                    curl_setopt($curl, CURLOPT_POST, 1);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, array(
                        'Apikey'    => $apikey,
                        'Phone'     => $phone,
                        'Message'   => $message,
                    ));
                    $response = curl_exec($curl);
                    curl_close($curl);

                    $res = json_decode($response, TRUE);

                    if ($res['wanotif']['status'] != 'sent') {
                        $userkey = '3efc3303a58c';
                        $passkey = 'kp6iswm84z';
                        $telepon = $telp;
                        $message = $pesan;

                        $url = 'https://console.zenziva.net/wareguler/api/sendWA/';
                        $curlHandle = curl_init();
                        curl_setopt($curlHandle, CURLOPT_URL, $url);
                        curl_setopt($curlHandle, CURLOPT_HEADER, 0);
                        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
                        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
                        curl_setopt($curlHandle, CURLOPT_TIMEOUT, 30);
                        curl_setopt($curlHandle, CURLOPT_POST, 1);
                        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, array(
                            'userkey' => $userkey,
                            'passkey' => $passkey,
                            'to' => $telepon,
                            'message' => $message
                        ));
                        $response = json_decode(curl_exec($curlHandle), true);
                        curl_close($curlHandle);
                    }

                    $resulte = $res['wanotif']['status'];

                    return $resulte;
                }

                send_wa($getTelp, $getPesan);
                send_wa($getTelpHRD, $getPesanHRD);

                return redirect()->route('karyawan.dashboard')->with(['success' => 'Berhasil Mengajukan Permohonan Cuti']);
            }
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        $id = Auth::user()->id;
        $permohonan = DB::table('users')
            ->join('permohonan_cuti', 'users.id', '=', 'permohonan_cuti.user_id')
            ->select('permohonan_cuti.id', 'users.name', 'permohonan_cuti.alasan_cuti', 'permohonan_cuti.tgl_mulai', 'permohonan_cuti.tgl_akhir', 'permohonan_cuti.status')
            ->where('permohonan_cuti.status', 'Di Ka.Divisi')
            ->where('permohonan_cuti.user_id', $id)
            ->get();

        return view('pages.permohonanCuti.karyawan', ['permohonan' => $permohonan]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('pages.permohonanCuti.disetujui');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function setuju(Request $request)
    {


        $data = DB::table('users')
            ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
            ->join('permohonan_cuti', 'users.id', '=', 'permohonan_cuti.user_id')
            ->select(
                'permohonan_cuti.id',
                'permohonan_cuti.user_id',
                'users.name',
                'permohonan_cuti.alasan_cuti',
                'permohonan_cuti.tgl_mulai',
                'permohonan_cuti.tgl_akhir',
                'permohonan_cuti.status',
                'karyawan.id',
                'users.no_telpon',
                'karyawan.jumlah_cuti'
            )
            ->where('permohonan_cuti.id', $request->custId)
            ->get();
        $user_id = '';
        // $alasan_cuti='';
        $tgl_mulai = '';
        $tgl_akhir = '';
        $status = '';
        $jumlah_cuti = '';


        foreach ($data as $key => $value) {
            $user_id = $value->user_id;
            // $alasan_cuti = $value->alasan_cuti ;
            $tgl_mulai = $value->tgl_mulai;
            $tgl_akhir = $value->tgl_akhir;
            $status = $value->status;
            $jumlah_cuti = $value->jumlah_cuti;
        }
        $tglMulai = date_create($tgl_mulai);
        $tglAkhir = date_create($tgl_akhir);
        $durasi = date_diff($tglMulai, $tglAkhir);

        $jmlCuti = $jumlah_cuti - $durasi->days - 1;

        DB::table('karyawan')->where('user_id', $user_id)->update([
            // 'user_id' => $user_id,
            'jumlah_cuti' => $jmlCuti,
        ]);

        DB::table('permohonan_cuti')->where('id', $request->custId)->update([
            // 'user_id' => $user_id,
            // 'alasan_cuti' => $alasan_cuti,
            // 'tgl_mulai' => $tgl_mulai,
            // 'tgl_akhir' => $tgl_akhir,
            'status' => "Diterima"
        ]);

        DB::table('permohonan_cuti')->where('id', $request->custId)->update([
            // 'user_id' => $user_id,
            'status' => "Diterima",
            'warna_cuti' => "#00ac69",
        ]);

        // Pesan untuk Karyawan

        $getUserId = DB::table('permohonan_cuti')
            ->where('id', $request->custId)
            ->value('user_id');

        $getNama = DB::table('users')
            ->join('permohonan_cuti', 'users.id', '=', 'permohonan_cuti.user_id')
            ->select(
                'users.name',
            )
            ->where('permohonan_cuti.id', $request->custId)
            ->value('users.name');
        $getDivisi = DB::table('users')
            ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
            ->select(
                'karyawan.divisi',
            )
            ->where('karyawan.user_id', $getUserId)
            ->value('karyawan.divisi');
        $getJabatan = DB::table('users')
            ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
            ->select(
                'karyawan.jabatan',
            )
            ->where('karyawan.user_id', $getUserId)
            ->value('karyawan.jabatan');

        $getTelp = DB::table('users')
            ->join('permohonan_cuti', 'users.id', '=', 'permohonan_cuti.user_id')
            ->select(
                'users.no_telpon',
            )
            ->where('permohonan_cuti.id', $request->custId)
            ->value('users.no_telpon');

        $tgl_akhir = DB::table('permohonan_cuti')
            ->where('permohonan_cuti.user_id', $getUserId)
            ->value('permohonan_cuti.tgl_akhir');

        $tgl_mulai = DB::table('permohonan_cuti')
            ->where('permohonan_cuti.user_id', $getUserId)
            ->value('permohonan_cuti.tgl_mulai');

        $alasan_cuti = DB::table('permohonan_cuti')
            ->where('permohonan_cuti.user_id', $getUserId)
            ->value('permohonan_cuti.alasan_cuti');

        $getPesan = "*Pengajuan* *Cuti* *Anda* *Disetujui*" . "\n\nNama: " . $getNama . "\nDivisi: " . $getDivisi . "\nJabatan: " . $getJabatan . "\nMulai Cuti: " . $tgl_mulai . "\nAkhir Cuti: " . $tgl_akhir . "\nAlasan Cuti: " . $alasan_cuti . "\n\nMohon mengecek web pengajuan cuti segera di www.cuti.booblestudio.com";

        //Pesan untuk HRD

        $getPesanHRD = "*Pengajuan* *Cuti* *Karyawan* *Disetujui*" . "\n\nNama: " . $getNama . "\nDivisi: " . $getDivisi . "\nJabatan: " . $getJabatan . "\nMulai Cuti: " . $tgl_mulai . "\nAkhir Cuti: " . $tgl_akhir . "\nAlasan Cuti: " . $alasan_cuti . "\n\nMohon mengecek web pengajuan cuti segera di www.cuti.booblestudio.com";

        $getTelpHRD = DB::table('users')
            ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
            ->where('users.role', 'HRD')
            ->value('users.no_telpon');

        function send_waSetuju($telp, $pesan)
        {
            // METHOD POST
            // Pastikan phone menggunakan kode negara 62 di depannya
            $phone = str_replace('08', '628', $telp);
            $message = $pesan;

            $apikey = '51Uy5loPoLC2FAuiAYhypAhv4IqU6xOy';
            $url = 'https://api.wanotif.id/v1/send';

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, array(
                'Apikey'    => $apikey,
                'Phone'     => $phone,
                'Message'   => $message,
            ));
            $response = curl_exec($curl);
            curl_close($curl);

            $res = json_decode($response, TRUE);

            if ($res['wanotif']['status'] != 'sent') {
                $userkey = '3efc3303a58c';
                $passkey = 'kp6iswm84z';
                $telepon = $telp;
                $message = $pesan;

                $url = 'https://console.zenziva.net/wareguler/api/sendWA/';
                $curlHandle = curl_init();
                curl_setopt($curlHandle, CURLOPT_URL, $url);
                curl_setopt($curlHandle, CURLOPT_HEADER, 0);
                curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
                curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curlHandle, CURLOPT_TIMEOUT, 30);
                curl_setopt($curlHandle, CURLOPT_POST, 1);
                curl_setopt($curlHandle, CURLOPT_POSTFIELDS, array(
                    'userkey' => $userkey,
                    'passkey' => $passkey,
                    'to' => $telepon,
                    'message' => $message
                ));
                $response = json_decode(curl_exec($curlHandle), true);
                curl_close($curlHandle);
            }

            $resulte = $res['wanotif']['status'];

            return $resulte;
        }

        send_waSetuju($getTelp, $getPesan);

        send_waSetuju($getTelpHRD, $getPesanHRD);

        return redirect()->route('permohonan.index')->with(['success' => 'Permohonan Cuti Karyawan Disetujui']);
    }

    public function kirimSebelumDuaHari()
    {
        $date = Carbon::now();
        $date->addDays(2);
        $currentTime = $date->isoFormat('YYYY-MM-DD');

        $jamKirim = Carbon::now()->format('H:i');


        // dd($mytime);

        // $coba = '2022-10-21';
        // $coba2 = Carbon::parse($coba)->isoFormat('YYYY-MM-DD');
        if ($jamKirim == "08:00") {
            $permohonan = DB::table('users')
                ->join('permohonan_cuti', 'users.id', '=', 'permohonan_cuti.user_id')
                ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
                ->select('users.name', 'permohonan_cuti.id', 'permohonan_cuti.user_id', 'permohonan_cuti.alasan_cuti', 'permohonan_cuti.tgl_mulai', 'permohonan_cuti.tgl_akhir', 'permohonan_cuti.status', 'permohonan_cuti.ket_tolak', 'permohonan_cuti.durasi_cuti', 'permohonan_cuti.tgl_memohon', 'permohonan_cuti.warna_cuti', 'karyawan.divisi', 'karyawan.jabatan', 'users.role', 'users.no_telpon')
                ->where('tgl_mulai', $currentTime)
                ->where(function ($query) {
                    $query->where('permohonan_cuti.status', 'Di Ka.Divisi');
                    $query->orWhere('permohonan_cuti.status', 'Di Direktur');
                })
                ->get();

            function send_waKirim($telp, $pesan)
            {
                // METHOD POST
                // Pastikan phone menggunakan kode negara 62 di depannya
                $phone = str_replace('08', '628', $telp);
                $message = $pesan;

                $apikey = '51Uy5loPoLC2FAuiAYhypAhv4IqU6xOy';
                $url = 'https://api.wanotif.id/v1/send';

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_HEADER, 0);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_TIMEOUT, 30);
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, array(
                    'Apikey'    => $apikey,
                    'Phone'     => $phone,
                    'Message'   => $message,
                ));
                $response = curl_exec($curl);
                curl_close($curl);

                $res = json_decode($response, TRUE);

                if ($res['wanotif']['status'] != 'sent') {
                    $userkey = '3efc3303a58c';
                    $passkey = 'kp6iswm84z';
                    $telepon = $telp;
                    $message = $pesan;

                    $url = 'https://console.zenziva.net/wareguler/api/sendWA/';
                    $curlHandle = curl_init();
                    curl_setopt($curlHandle, CURLOPT_URL, $url);
                    curl_setopt($curlHandle, CURLOPT_HEADER, 0);
                    curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
                    curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
                    curl_setopt($curlHandle, CURLOPT_TIMEOUT, 30);
                    curl_setopt($curlHandle, CURLOPT_POST, 1);
                    curl_setopt($curlHandle, CURLOPT_POSTFIELDS, array(
                        'userkey' => $userkey,
                        'passkey' => $passkey,
                        'to' => $telepon,
                        'message' => $message
                    ));
                    $response = json_decode(curl_exec($curlHandle), true);
                    curl_close($curlHandle);
                }

                $resulte = $res['wanotif']['status'];

                return $resulte;
            }

            foreach ($permohonan as $p) {
                if ($p->role === "karyawan") {
                    $getPesan = "*Pengajuan* *Cuti* *Karyawan*" . "\n\nNama: " . $p->name . "\nDivisi: " . $p->divisi . "\nJabatan: " . $p->jabatan . "\nMulai Cuti: " . $p->tgl_mulai . "\nAkhir Cuti: " . $p->tgl_akhir . "\nAlasan Cuti: " . $p->alasan_cuti . "\n\nMohon mengecek web pengajuan cuti segera di www.cuti.booblestudio.com";

                    $getTelp = DB::table('users')
                        ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
                        ->where('users.role', 'Kepala Divisi')
                        ->where('karyawan.divisi', $p->divisi)
                        ->value('users.no_telpon');

                    //Pesan untuk HRD

                    $getPesanHRD = "*Pengajuan* *Cuti* *Karyawan*" . "\n\nNama: " . $p->name . "\nDivisi: " . $p->divisi . "\nJabatan: " . $p->jabatan . "\nMulai Cuti: " . $p->tgl_mulai . "\nAkhir Cuti: " . $p->tgl_akhir . "\nAlasan Cuti: " . $p->alasan_cuti . "\n\nMohon mengecek web pengajuan cuti segera di www.cuti.booblestudio.com";

                    $getTelpHRD = DB::table('users')
                        ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
                        ->where('users.role', 'HRD')
                        ->value('users.no_telpon');

                    send_waKirim($getTelp, $getPesan);

                    send_waKirim($getTelpHRD, $getPesanHRD);
                } else {
                    $getPesan = "*Pengajuan* *Cuti* *Karyawan*" . "\n\nNama: " . $p->name . "\nDivisi: " . $p->divisi . "\nJabatan: " . $p->jabatan . "\nMulai Cuti: " . $p->tgl_mulai . "\nAkhir Cuti: " . $p->tgl_akhir . "\nAlasan Cuti: " . $p->alasan_cuti . "\n\nMohon mengecek web pengajuan cuti segera di www.cuti.booblestudio.com";

                    $getTelp = DB::table('users')
                        ->where('role', 'Leader')
                        ->value('no_telpon');

                    //Pesan untuk HRD

                    $getPesanHRD = "*Pengajuan* *Cuti* *Karyawan*" . "\n\nNama: " . $p->name . "\nDivisi: " . $p->divisi . "\nJabatan: " . $p->jabatan . "\nMulai Cuti: " . $p->tgl_mulai . "\nAkhir Cuti: " . $p->tgl_akhir . "\nAlasan Cuti: " . $p->alasan_cuti . "\n\nMohon mengecek web pengajuan cuti segera di www.cuti.booblestudio.com";

                    $getTelpHRD = DB::table('users')
                        ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
                        ->where('users.role', 'HRD')
                        ->value('users.no_telpon');

                    send_waKirim($getTelp, $getPesan);

                    send_waKirim($getTelpHRD, $getPesanHRD);
                }
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function dikirim($id)
    // {

    //     $data = DB::table('users')
    //         ->join('permohonan_cuti', 'users.id', '=', 'permohonan_cuti.user_id')
    //         ->select('permohonan_cuti.id', 'permohonan_cuti.user_id', 'permohonan_cuti.status')
    //         ->where('permohonan_cuti.id', $id)
    //         ->get();

    //     DB::table('permohonan_cuti')->where('id', $id)->update([
    //         // 'user_id' => $user_id,
    //         'status' => "Di Direktur",
    //         'warna_cuti' => "#6900c7",
    //     ]);

    //     $getNama = DB::table('users')
    //         ->join('permohonan_cuti', 'users.id', '=', 'permohonan_cuti.user_id')
    //         ->where('permohonan_cuti.id', $id)
    //         ->value('users.name');

    //     $getPesan = 'Pesan Dari Kepala Divisi. Pengajuan cuti baru oleh' . ' ' . $getNama . '. Mohon mengecek web cuti Booble.id';

    //     $getTelp = DB::table('users')
    //         ->where('role', 'Leader')
    //         ->value('no_telpon');

    //     function send_waDikirim($telp, $pesan)
    //     {
    //         // METHOD POST
    //         // Pastikan phone menggunakan kode negara 62 di depannya
    //         $phone = str_replace('08', '628', $telp);
    //         $message = $pesan;

    //         $apikey = '51Uy5loPoLC2FAuiAYhypAhv4IqU6xOy';
    //         $url = 'https://api.wanotif.id/v1/send';

    //         $curl = curl_init();
    //         curl_setopt($curl, CURLOPT_URL, $url);
    //         curl_setopt($curl, CURLOPT_HEADER, 0);
    //         curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    //         curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
    //         curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    //         curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    //         curl_setopt($curl, CURLOPT_POST, 1);
    //         curl_setopt($curl, CURLOPT_POSTFIELDS, array(
    //             'Apikey'    => $apikey,
    //             'Phone'     => $phone,
    //             'Message'   => $message,
    //         ));
    //         $response = curl_exec($curl);
    //         curl_close($curl);

    //         $res = json_decode($response, TRUE);

    //         if ($res['wanotif']['status'] != 'sent') {
    //             $userkey = '3efc3303a58c';
    //             $passkey = 'kp6iswm84z';
    //             $telepon = $telp;
    //             $message = $pesan;

    //             $url = 'https://console.zenziva.net/wareguler/api/sendWA/';
    //             $curlHandle = curl_init();
    //             curl_setopt($curlHandle, CURLOPT_URL, $url);
    //             curl_setopt($curlHandle, CURLOPT_HEADER, 0);
    //             curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
    //             curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
    //             curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
    //             curl_setopt($curlHandle, CURLOPT_TIMEOUT, 30);
    //             curl_setopt($curlHandle, CURLOPT_POST, 1);
    //             curl_setopt($curlHandle, CURLOPT_POSTFIELDS, array(
    //                 'userkey' => $userkey,
    //                 'passkey' => $passkey,
    //                 'to' => $telepon,
    //                 'message' => $message
    //             ));
    //             $response = json_decode(curl_exec($curlHandle), true);
    //             curl_close($curlHandle);
    //         }

    //         $resulte = $res['wanotif']['status'];

    //         return $resulte;
    //     }

    //     send_waDikirim($getTelp, $getPesan);

    //     return redirect()->route('permohonan.index')->with(['success' => 'Permohonan Cuti Telah Dikirim ke Atasan']);
    // }

    public function dibatalkan(Request $request)
    {
        $data = DB::table('users')
            ->join('permohonan_cuti', 'users.id', '=', 'permohonan_cuti.user_id')
            ->select('permohonan_cuti.id', 'permohonan_cuti.user_id', 'permohonan_cuti.status')
            ->where('permohonan_cuti.id', $request->custId)
            ->get();

        DB::table('permohonan_cuti')->where('id', $request->custId)->update([
            // 'user_id' => $user_id,
            'status' => "Dibatalkan"
        ]);

        return redirect()->route('karyawan.dashboard')->with(['success' => 'Permohonan Cuti Telah Dibatalkan']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function tolak(Request $request)
    {

        $data = DB::table('users')
            ->join('permohonan_cuti', 'users.id', '=', 'permohonan_cuti.user_id')
            ->select(
                'permohonan_cuti.id',
                'permohonan_cuti.user_id',
                'users.name',
                'permohonan_cuti.alasan_cuti',
                'permohonan_cuti.tgl_mulai',
                'permohonan_cuti.tgl_akhir',
                'permohonan_cuti.status',
                'permohonan_cuti.ket_tolak'
            )
            ->where('permohonan_cuti.id', $request->custId)
            ->get();


        $user_id = '';
        // $alasan_cuti='';
        $tgl_mulai = '';
        $tgl_akhir = '';
        $status = '';
        $ket_tolak = '';



        foreach ($data as $key => $value) {
            $user_id = $value->user_id;
            $ket_tolak = $value->ket_tolak;
            // $alasan_cuti = $value->alasan_cuti ;
            $tgl_mulai = $value->tgl_mulai;
            $tgl_akhir = $value->tgl_akhir;
            $status = $value->status;
        }

        DB::table('permohonan_cuti')->where('id', $request->custId)->update([
            // 'user_id' => $request->custId,
            // 'alasan_cuti' => $alasan_cuti,
            // 'tgl_mulai' => $tgl_mulai,
            // 'tgl_akhir' => $tgl_akhir,
            'status' => "Ditolak",
            'ket_tolak' => $request->ket_tolak,
        ]);

        // Pesan untuk Karyawan

        $getUserId = DB::table('permohonan_cuti')
            ->where('id', $request->custId)
            ->value('user_id');

        $getNama = DB::table('users')
            ->join('permohonan_cuti', 'users.id', '=', 'permohonan_cuti.user_id')
            ->select(
                'users.name',
            )
            ->where('permohonan_cuti.id', $request->custId)
            ->value('users.name');
        $getDivisi = DB::table('users')
            ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
            ->select(
                'karyawan.divisi',
            )
            ->where('karyawan.user_id', $getUserId)
            ->value('karyawan.divisi');
        $getJabatan = DB::table('users')
            ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
            ->select(
                'karyawan.jabatan',
            )
            ->where('karyawan.user_id', $getUserId)
            ->value('karyawan.jabatan');

        $getTelp = DB::table('users')
            ->join('permohonan_cuti', 'users.id', '=', 'permohonan_cuti.user_id')
            ->select(
                'users.no_telpon',
            )
            ->where('permohonan_cuti.id', $request->custId)
            ->value('users.no_telpon');

        $tgl_akhir = DB::table('permohonan_cuti')
            ->where('permohonan_cuti.user_id', $getUserId)
            ->value('permohonan_cuti.tgl_akhir');

        $tgl_mulai = DB::table('permohonan_cuti')
            ->where('permohonan_cuti.user_id', $getUserId)
            ->value('permohonan_cuti.tgl_mulai');

        $alasan_cuti = DB::table('permohonan_cuti')
            ->where('permohonan_cuti.user_id', $getUserId)
            ->value('permohonan_cuti.alasan_cuti');

        $getPesan = "*Pengajuan* *Cuti* *Anda* *Ditolak*" . "\n\nNama: " . $getNama . "\nDivisi: " . $getDivisi . "\nJabatan: " . $getJabatan . "\nMulai Cuti: " . $tgl_mulai . "\nAkhir Cuti: " . $tgl_akhir . "\nAlasan Cuti: " . $alasan_cuti . "\nAlasan Ditolak: " . "*" . $request->ket_tolak . "*" . "\n\nMohon mengecek web pengajuan cuti segera di www.cuti.booblestudio.com";

        //Pesan untuk HRD

        $getPesanHRD = "*Pengajuan* *Cuti* *Karyawan* *Ditolak*" . "\n\nNama: " . $getNama . "\nDivisi: " . $getDivisi . "\nJabatan: " . $getJabatan . "\nMulai Cuti: " . $tgl_mulai . "\nAkhir Cuti: " . $tgl_akhir . "\nAlasan Cuti: " . $alasan_cuti . "\nAlasan Ditolak: " . "*" . $request->ket_tolak . "*" . "\n\nMohon mengecek web pengajuan cuti segera di www.cuti.booblestudio.com";

        $getTelpHRD = DB::table('users')
            ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
            ->where('users.role', 'HRD')
            ->value('users.no_telpon');

        function send_wa($telp, $pesan)
        {
            // METHOD POST
            // Pastikan phone menggunakan kode negara 62 di depannya
            $phone = str_replace('08', '628', $telp);
            $message = $pesan;

            $apikey = '51Uy5loPoLC2FAuiAYhypAhv4IqU6xOy';
            $url = 'https://api.wanotif.id/v1/send';

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, array(
                'Apikey'    => $apikey,
                'Phone'     => $phone,
                'Message'   => $message,
            ));
            $response = curl_exec($curl);
            curl_close($curl);

            $res = json_decode($response, TRUE);

            if ($res['wanotif']['status'] != 'sent') {
                $userkey = '3efc3303a58c';
                $passkey = 'kp6iswm84z';
                $telepon = $telp;
                $message = $pesan;

                $url = 'https://console.zenziva.net/wareguler/api/sendWA/';
                $curlHandle = curl_init();
                curl_setopt($curlHandle, CURLOPT_URL, $url);
                curl_setopt($curlHandle, CURLOPT_HEADER, 0);
                curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
                curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curlHandle, CURLOPT_TIMEOUT, 30);
                curl_setopt($curlHandle, CURLOPT_POST, 1);
                curl_setopt($curlHandle, CURLOPT_POSTFIELDS, array(
                    'userkey' => $userkey,
                    'passkey' => $passkey,
                    'to' => $telepon,
                    'message' => $message
                ));
                $response = json_decode(curl_exec($curlHandle), true);
                curl_close($curlHandle);
            }

            $resulte = $res['wanotif']['status'];

            return $resulte;
        }

        send_wa($getTelp, $getPesan);

        send_wa($getTelpHRD, $getPesanHRD);

        return redirect()->route('permohonan.index')->with(['success' => 'Permohonan Cuti Berhasi Ditolak!']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function alasanTolak(Request $request)
    {
        DB::table('permohonan_cuti')
            ->where('id', $request->id)
            ->update([
                'ket_tolak' => $request->ket_tolak,
            ]);

        return redirect()->route('permohonan.index')->with(['success' => 'Permohonan Cuti Berhasi Ditolak!']);
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
