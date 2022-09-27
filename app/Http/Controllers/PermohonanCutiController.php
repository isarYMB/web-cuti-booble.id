<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Permohonan_Cuti;
use App\Models\Karyawan;
use DB;
use Auth;
use PDF;
use DateTime;




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
            ->join('permohonan_cuti','users.id','=','permohonan_cuti.user_id')
            ->join('karyawan','users.id','=','karyawan.user_id')
            ->select('permohonan_cuti.id','users.name','permohonan_cuti.alasan_cuti','permohonan_cuti.tgl_mulai','permohonan_cuti.tgl_memohon','permohonan_cuti.durasi_cuti','permohonan_cuti.tgl_akhir','permohonan_cuti.status','permohonan_cuti.ket_tolak')
            ->where(
                function($query) {
                    return $query
                        ->where('permohonan_cuti.status', '=', 'Baru')
                        ->orWhere('permohonan_cuti.status', '=', 'Diatasan');
                });
            // ->get();

            $permohonan = $permohonanDivisi->where('karyawan.divisi', Auth::user()->karyawan->divisi)->get();

            $permohonanTerima = DB::table('users')
            ->join('permohonan_cuti','users.id','=','permohonan_cuti.user_id')
            ->join('karyawan','users.id','=','karyawan.user_id')
            ->select('users.name','karyawan.divisi','permohonan_cuti.id','permohonan_cuti.alasan_cuti','permohonan_cuti.tgl_mulai','permohonan_cuti.tgl_akhir','permohonan_cuti.status','permohonan_cuti.ket_tolak','permohonan_cuti.durasi_cuti','permohonan_cuti.tgl_memohon')
            ->where('permohonan_cuti.status','Diterima')
            // ->limit(5)
            ->get();

        } elseif (Auth::user()->role === "Leader"){
            $permohonan = DB::table('users')
            ->join('permohonan_cuti','users.id','=','permohonan_cuti.user_id')
            ->select('permohonan_cuti.id','users.name','permohonan_cuti.alasan_cuti','permohonan_cuti.tgl_mulai','permohonan_cuti.tgl_memohon','permohonan_cuti.durasi_cuti','permohonan_cuti.tgl_akhir','permohonan_cuti.status')
            ->where('permohonan_cuti.status','Diatasan')
            ->get();

            $permohonanTerima = DB::table('users')
            ->join('permohonan_cuti','users.id','=','permohonan_cuti.user_id')
            ->join('karyawan','users.id','=','karyawan.user_id')
            ->select('users.name','karyawan.divisi','permohonan_cuti.id','permohonan_cuti.alasan_cuti','permohonan_cuti.tgl_mulai','permohonan_cuti.tgl_akhir','permohonan_cuti.status','permohonan_cuti.ket_tolak','permohonan_cuti.durasi_cuti','permohonan_cuti.tgl_memohon')
            ->where('permohonan_cuti.status','Diterima')
            // ->limit(5)
            ->get();

            
        }
        
        return view('pages.permohonanCuti.index',['permohonan' => $permohonan,'permohonanTerima' => $permohonanTerima]);
        
    }

    public function isiSurat(Request $request)
    {
        $dataSurat = DB::table('users')
        ->join('permohonan_cuti','users.id','=','permohonan_cuti.user_id')
        ->join('karyawan','users.id','=','karyawan.user_id')
        ->select('users.name','users.nik','karyawan.jabatan','karyawan.divisi','permohonan_cuti.id','permohonan_cuti.user_id','permohonan_cuti.status','permohonan_cuti.durasi_cuti','permohonan_cuti.alasan_cuti','permohonan_cuti.tgl_mulai','permohonan_cuti.tgl_akhir','users.no_telpon',)
        ->where('permohonan_cuti.id',$request->custId)
        ->get();

        // $tglMulai = DB::table('permohonan_cuti')
        // ->where('id',$id)
        // ->value('tgl_mulai');

        // $date = new DateTime($tglMulai);
        // $dateNewTime = $date->format('Y-m-d H:i:s');

        // $registeredAt = $dateNewTime->isoFormat('dddd, D MMMM Y');
        $mengetahuiOleh = $request->mengetahuiOleh;
        $namaAtasan = $request->namaAtasan;

        $tanggalCuti = Permohonan_Cuti::find($request->custId);
        $hariMulai = $tanggalCuti->tgl_mulai->isoFormat('dddd');
        $hariAkhir = $tanggalCuti->tgl_akhir->isoFormat('dddd');
        $tglMulai = $tanggalCuti->tgl_mulai->isoFormat('D MMMM Y');
        $tglAkhir = $tanggalCuti->tgl_akhir->isoFormat('D MMMM Y');


        $hariIni = Carbon::now()->isoFormat('D MMMM Y');
        
        $pdf = PDF ::loadview('pages.permohonanCuti.surat',['dataSurat' => $dataSurat, 'hariIni' => $hariIni, 'hariMulai' => $hariMulai, 'hariAkhir'=>$hariAkhir, 'tglMulai'=>$tglMulai, 'tglAkhir'=>$tglAkhir, 'namaAtasan'=>$namaAtasan, 'mengetahuiOleh'=>$mengetahuiOleh])->setpaper('A4','potrait');
        return $pdf -> stream('Surat_Cuti_Booble.id.pdf');

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
        $id=Auth::user()->id;
        $permohonan = DB::table('karyawan')
            ->join('permohonan_cuti','karyawan.id','=','permohonan_cuti.user_id')
            ->select('karyawan.jumlah_cuti')
            ->where('karyawan.user_id','id')
            ->get();
            
        // $divisiUser='Akuntan';
        // $jadwalSama = DB::table('karyawan')
        //     ->join('permohonan_cuti','karyawan.id','=','permohonan_cuti.user_id')
        //     ->select('permohonan_cuti.tgl_mulai','permohonan_cuti.tgl_akhir')
        //     ->where('karyawan.divisi','divisiUser')
        //     ->get();

        // $jadwalSama = Divisi::all();

        // $arrayTanggal = [];
        // foreach ($jadwalSama as $jadwalsama){
        //     $arrayTanggal = $jadwalsama;
        // }

        // dd($arrayTanggal);
            

        $data = DB::table('karyawan')->select('jumlah_cuti')->where('user_id',$id)->get();

        $sisaCuti =$data[0]->jumlah_cuti;

        $tglMulai = date_create($request->tgl_mulai);
        $tglAkhir = date_create($request->tgl_akhir);
        $durasi = date_diff($tglAkhir,$tglMulai);
        
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

        if($jumlahCuti < 0){
            return redirect()->route('karyawan.dashboard')->with(['message' => 'Maaf anda tidak bisa mengajukan cuti karena sisa cuti anda sudah habis']);
        }
        elseif($durasi->format('%d') > 4){
            return redirect()->route('karyawan.dashboard')->with(['message' => 'Maaf anda tidak bisa mengajukan cuti karena durasi cuti maksimal 4 hari sekali pangajuan']);
        }
        elseif($is_weekend == 1){
            $totalCuti = $durasi->days - 0;
            DB::table('permohonan_cuti')->insert([
                'user_id' => Auth::id(),
                'alasan_cuti' => $request->alasan_cuti,
                'tgl_mulai' => $request->tgl_mulai,
                'tgl_akhir' => $request->tgl_akhir,
                'durasi_cuti' => $totalCuti,
                'tgl_memohon' => Carbon::now(),
                'status' => 'Baru'
            ]);

            $getNama = auth()->user()->value('name');

            $getPesan = 'Pesan Dari Karyawan. Pengajuan cuti baru oleh'.' '.$getNama.'. Mohon mengecek web cuti Booble.id';

            $getTelp = DB::table('users')
            ->where('role','Staf HR')
            ->value('no_telpon');

            function send_wa($telp, $pesan)
            {
            // METHOD POST
            // Pastikan phone menggunakan kode negara 62 di depannya
            $phone = str_replace('08','628',$telp);
            $message = $pesan;
            
            $apikey = '51Uy5loPoLC2FAuiAYhypAhv4IqU6xOy';
            $url = 'https://api.wanotif.id/v1/send';
        
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_TIMEOUT,30);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, array(
            'Apikey'    => $apikey,
            'Phone'     => $phone,
            'Message'   => $message,
            ));
            $response = curl_exec($curl);
            curl_close($curl); 
        
            $res = json_decode($response, TRUE);
        
            if($res['wanotif']['status'] != 'sent'){
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


            return redirect()->route('karyawan.dashboard')->with(['success' => 'Berhasil Mengajukan Permohonan Cuti (Ada minggu)']);
        }
        else{

            $totalCuti = $durasi->days + 1;

            DB::table('permohonan_cuti')->insert([
                'user_id' => Auth::id(),
                'alasan_cuti' => $request->alasan_cuti,
                'tgl_mulai' => $request->tgl_mulai,
                'tgl_akhir' => $request->tgl_akhir,
                'durasi_cuti' => $totalCuti,
                'tgl_memohon' => Carbon::now(),
                'status' => 'Baru'
            ]);

            $getNama = auth()->user()->value('name');

            $getPesan = 'Pesan Dari Karyawan. Pengajuan cuti baru oleh'.' '.$getNama.'. Mohon mengecek web cuti Booble.id';

            $getTelp = DB::table('users')
            ->where('role','Staf HR')
            ->value('no_telpon');

            function send_wa($telp, $pesan)
            {
            // METHOD POST
            // Pastikan phone menggunakan kode negara 62 di depannya
            $phone = str_replace('08','628',$telp);
            $message = $pesan;
            
            $apikey = '51Uy5loPoLC2FAuiAYhypAhv4IqU6xOy';
            $url = 'https://api.wanotif.id/v1/send';
        
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_TIMEOUT,30);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, array(
            'Apikey'    => $apikey,
            'Phone'     => $phone,
            'Message'   => $message,
            ));
            $response = curl_exec($curl);
            curl_close($curl); 
        
            $res = json_decode($response, TRUE);
        
            if($res['wanotif']['status'] != 'sent'){
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

            return redirect()->route('karyawan.dashboard')->with(['success' => 'Berhasil Mengajukan Permohonan Cuti']);
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
        $id=Auth::user()->id;
        $permohonan = DB::table('users')
            ->join('permohonan_cuti','users.id','=','permohonan_cuti.user_id')
            ->select('permohonan_cuti.id','users.name','permohonan_cuti.alasan_cuti','permohonan_cuti.tgl_mulai','permohonan_cuti.tgl_akhir','permohonan_cuti.status')
            ->where('permohonan_cuti.status','Baru')
            ->where('permohonan_cuti.user_id',$id)
            ->get();

        return view('pages.permohonanCuti.karyawan',['permohonan' => $permohonan]);
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
    public function setuju($id)
    {
        $data = DB::table('users')
        ->join('karyawan','users.id','=','karyawan.user_id')
        ->join('permohonan_cuti','users.id','=','permohonan_cuti.user_id')
        ->select('permohonan_cuti.id','permohonan_cuti.user_id','users.name',
                'permohonan_cuti.alasan_cuti','permohonan_cuti.tgl_mulai',
                'permohonan_cuti.tgl_akhir','permohonan_cuti.status',
                'karyawan.id','users.no_telpon',
                'karyawan.jumlah_cuti'
                )
        ->where('permohonan_cuti.id',$id)
        ->get();
        $user_id='';
        // $alasan_cuti='';
        $tgl_mulai='';
        $tgl_akhir='';
        $status='';
        $jumlah_cuti='';

        foreach ($data as $key => $value) {
            $user_id = $value->user_id ;
            // $alasan_cuti = $value->alasan_cuti ;
            $tgl_mulai = $value->tgl_mulai;
            $tgl_akhir = $value->tgl_akhir;
            $status = $value->status;
            $jumlah_cuti = $value->jumlah_cuti;
        }
        $tglMulai = date_create($tgl_mulai);
        $tglAkhir = date_create($tgl_akhir);
        $durasi = date_diff($tglMulai,$tglAkhir);
        
        $jmlCuti=$jumlah_cuti - $durasi->days;

        DB::table('karyawan')->where('user_id',$user_id)->update([
            'user_id' => $user_id,
            'jumlah_cuti' => $jmlCuti,
        ]);
        
        DB::table('permohonan_cuti')->where('id',$id)->update([
            'user_id' => $user_id,
            // 'alasan_cuti' => $alasan_cuti,
            // 'tgl_mulai' => $tgl_mulai,
            // 'tgl_akhir' => $tgl_akhir,
            'status' => "Diterima"
        ]);

        $getPesan = 'Permohonan Cuti Anda Telah Disetujui Oleh Atasan';

        $getTelp = DB::table('users')
        ->where('id',$id)
        ->value('no_telpon');

        function send_wa($telp, $pesan)
        {
        // METHOD POST
        // Pastikan phone menggunakan kode negara 62 di depannya
        $phone = str_replace('08','628',$telp);
        $message = $pesan;
        
        $apikey = '51Uy5loPoLC2FAuiAYhypAhv4IqU6xOy';
        $url = 'https://api.wanotif.id/v1/send';
    
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_TIMEOUT,30);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, array(
        'Apikey'    => $apikey,
        'Phone'     => $phone,
        'Message'   => $message,
        ));
        $response = curl_exec($curl);
        curl_close($curl); 
    
        $res = json_decode($response, TRUE);
    
        if($res['wanotif']['status'] != 'sent'){
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

        return redirect()->route('permohonan.index')->with(['success' => 'Permohonan Cuti Berhasil Disetujui']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function dikirim($id)
    {
        $data = DB::table('users')
        ->join('permohonan_cuti','users.id','=','permohonan_cuti.user_id')
        ->select('permohonan_cuti.id','permohonan_cuti.user_id','permohonan_cuti.status')
        ->where('permohonan_cuti.id',$id)
        ->get();
        
        DB::table('permohonan_cuti')->where('id',$id)->update([
            // 'user_id' => $user_id,
            'status' => "Diatasan"
        ]);

        $getNama = DB::table('users')
        ->join('permohonan_cuti','users.id','=','permohonan_cuti.user_id')
        ->where('permohonan_cuti.id',$id)
        ->value('users.name');

        $getPesan = 'Pesan Dari HRD. Pengajuan cuti baru oleh'.' '.$getNama.'. Mohon mengecek web cuti Booble.id';

        $getTelp = DB::table('users')
            ->where('role','Leader')
            ->value('no_telpon');

        function send_wa($telp, $pesan)
        {
        // METHOD POST
        // Pastikan phone menggunakan kode negara 62 di depannya
        $phone = str_replace('08','628',$telp);
        $message = $pesan;
        
        $apikey = '51Uy5loPoLC2FAuiAYhypAhv4IqU6xOy';
        $url = 'https://api.wanotif.id/v1/send';
    
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_TIMEOUT,30);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, array(
        'Apikey'    => $apikey,
        'Phone'     => $phone,
        'Message'   => $message,
        ));
        $response = curl_exec($curl);
        curl_close($curl); 
    
        $res = json_decode($response, TRUE);
    
        if($res['wanotif']['status'] != 'sent'){
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
        
        return redirect()->route('permohonan.index')->with(['success' => 'Permohonan Cuti Telah Dikirim ke Atasan']);
    }

    public function dibatalkan($id)
    {
        $data = DB::table('users')
        ->join('permohonan_cuti','users.id','=','permohonan_cuti.user_id')
        ->select('permohonan_cuti.id','permohonan_cuti.user_id','permohonan_cuti.status')
        ->where('permohonan_cuti.id',$id)
        ->get();
        
        DB::table('permohonan_cuti')->where('id',$id)->update([
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
        ->join('permohonan_cuti','users.id','=','permohonan_cuti.user_id')
        ->select('permohonan_cuti.id','permohonan_cuti.user_id','users.name',
                'permohonan_cuti.alasan_cuti','permohonan_cuti.tgl_mulai',
                'permohonan_cuti.tgl_akhir','permohonan_cuti.status','permohonan_cuti.ket_tolak'
                )
        ->where('permohonan_cuti.id',$request->custId)
        ->get();


        $user_id='';
        // $alasan_cuti='';
        $tgl_mulai='';
        $tgl_akhir='';
        $status='';
        $ket_tolak='';

        

        foreach ($data as $key => $value) {
            $user_id = $value->user_id ;
            $ket_tolak = $value->ket_tolak ;
            // $alasan_cuti = $value->alasan_cuti ;
            $tgl_mulai = $value->tgl_mulai;
            $tgl_akhir = $value->tgl_akhir;
            $status = $value->status;
        }
        
        DB::table('permohonan_cuti')->where('id',$request->custId)->update([
            'user_id' => $user_id,
            // 'alasan_cuti' => $alasan_cuti,
            // 'tgl_mulai' => $tgl_mulai,
            // 'tgl_akhir' => $tgl_akhir,
            'status' => "Ditolak",
            'ket_tolak' => $request->ket_tolak,
        ]);

        $getPesan = $request->ket_tolak;

        $getTelp = DB::table('users')
        ->where('id',$request->custId)
        ->value('no_telpon');

        function send_wa($telp, $pesan)
        {
        // METHOD POST
        // Pastikan phone menggunakan kode negara 62 di depannya
        $phone = str_replace('08','628',$telp);
        $message = $pesan;
        
        $apikey = '51Uy5loPoLC2FAuiAYhypAhv4IqU6xOy';
        $url = 'https://api.wanotif.id/v1/send';
    
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_TIMEOUT,30);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, array(
        'Apikey'    => $apikey,
        'Phone'     => $phone,
        'Message'   => $message,
        ));
        $response = curl_exec($curl);
        curl_close($curl); 
    
        $res = json_decode($response, TRUE);
    
        if($res['wanotif']['status'] != 'sent'){
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