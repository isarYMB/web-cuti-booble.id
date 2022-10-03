<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Divisi;
use App\Models\Jabatan;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use DB;
use App\Mail\SendEmail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $karyawan = DB::table('users')
            ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
            ->select('users.name', 'users.role', 'users.email', 'users.nik', 'karyawan.user_id', 'karyawan.id', 'users.password', 'users.no_telpon', 'karyawan.jumlah_cuti', 'karyawan.jabatan', 'karyawan.divisi')
            ->orderBy('users.name')
            ->get();

        return view('pages.karyawan.index', ['karyawan' => $karyawan]);
    }

    public function indexUpdateUser()
    {

        return view('pages.karyawan.FormEditUser')->with(['success' => 'Data Karyawan Berhasil Diupdate!']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $divisi = Divisi::all();
        $jabatan = Jabatan::all();
        $role = Role::all();

        return view('pages.karyawan.FormCreate', ['divisi' => $divisi, 'jabatan' => $jabatan, 'role' => $role]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

        $randomPassword = Str::random(10);
        $hashPassword = Hash::make($randomPassword);

        $name = $request->old('name');
        $nik = $request->old('nik');
        $email = $request->old('email');
        $no_telpon = $request->old('no_telpon');
        $role = $request->old('role');
        $divisi = $request->old('divisi');
        $jabatan = $request->old('jabatan');
        $jumlah_cuti = $request->old('jumlah_cuti');

        $validasiUser = $request->validate([
            'name' => 'required|max:255',
            'nik' => 'required|max:16|min:16',
            'email' => 'required|unique:users,email',
            'password' => 'min:6',
            'role' => 'required',
            'no_telpon' => 'required|max:13|min:12',
        ]);

        $validasiKaryawan = $request->validate([
            'divisi' => 'required',
            'jabatan' => 'required',
            'jumlah_cuti' => 'required|max:2|min:1',
        ]);


        $validasiUser['password'] = $hashPassword;




        // User::create($validasiUser);

        // Karyawan::create($validasiKaryawan);

        $user = User::create($validasiUser);
        $user->karyawan()->create($validasiKaryawan);

        $isi_email = [
            'title' => 'Akun Permohonan Cuti Anda Telah Dibuat',
            'body' => 'Silahkan login dengan email dan password di bawah dan lakukan pengubahan password segera.',
            'email' => $validasiUser['email'],
            'password' => $randomPassword
        ];

        Mail::to($validasiUser['email'])->send(new SendEmail($isi_email));

        return redirect()->route('karyawan.index')->with(['success' => 'Data Karyawan Berhasil Ditambahkan!'])->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $karyawan = DB::table('users')
            ->join('karyawan', 'users.id', '=', 'karyawan.user_id')
            ->select('users.name', 'users.role', 'karyawan.jabatan', 'karyawan.divisi', 'users.nik', 'users.email', 'karyawan.id', 'users.no_telpon', 'users.password', 'users.email', 'karyawan.jumlah_cuti')
            ->where('karyawan.id', $id)
            ->get();

        $listDivisi = Divisi::all();
        $listJabatan = Jabatan::all();
        $listRole = Role::all();

        return view('pages.karyawan.FormEdit', ['karyawan' => $karyawan, 'listDivisi' => $listDivisi, 'listJabatan' => $listJabatan, 'listRole' => $listRole]);
    }

    public function editUser()
    {



        return view('pages.karyawan.FormEditUser')->with(['success' => 'Data Profil Kamu Berhasil Diupdate!']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateUser(Request $request)
    {

        if ($request->password != '') {

            $validasiUser = $request->validate([
                'no_telpon' => ['required', 'max:13', 'min:12'],
                'password' => ['required', 'confirmed', 'min:6'],
                'email' => ['email'],
            ]);

            $validasiUser['password'] = Hash::make($validasiUser['password']);

            DB::table('users')
                ->where('id', $request->id)
                ->update([
                    'email' => $validasiUser['email'],
                    'password' => $validasiUser['password'],
                    'no_telpon' => $validasiUser['no_telpon']
                ]);
        } else {
            $validasiUser = $request->validate([
                'no_telpon' => ['required', 'max:13', 'min:12'],
                'email' => ['email'],
            ]);

            DB::table('users')
                ->where('id', $request->id)
                ->update([
                    'email' => $validasiUser['email'],
                    'no_telpon' => $validasiUser['no_telpon']
                ]);
        }


        // return view('karyawan.editUser')->with(['success' => 'Data Karyawan Berhasil Diupdate!']);

        return redirect()->route('karyawan.editUser')->with(['success' => 'Data Profil Kamu Berhasil Diupdate!']);
    }

    public function resetJumlahCuti()
    {
        $resetCuti = 12;
        DB::table('karyawan')
            ->update([
                'jumlah_cuti' => $resetCuti,
            ]);

        return "Berhasil Reset Cuti Semua Karyawan Booble.id";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {


        if ($request->password != '') {
            $validasiUser = $request->validate([
                'name' => ['required', 'max:255'],
                'nik' => ['required', 'max:16', 'min:16'],
                'email' => ['email'],
                'password' => ['required', 'confirmed', 'min:6'],
                'no_telpon' => ['required', 'max:13', 'min:12'],
                'role' => ['required'],
            ]);

            $validasiKaryawan = $request->validate([
                'divisi' => ['required'],
                'jabatan' => ['required'],
                'jumlah_cuti' => ['required', 'max:2', 'min:1'],
            ]);

            $validasiUser['password'] = Hash::make($validasiUser['password']);

            DB::table('users')
                ->where('id', $request->id)
                ->update([
                    'name' => $validasiUser['name'],
                    'nik' => $validasiUser['nik'],
                    'email' => $validasiUser['email'],
                    'password' => $validasiUser['password'],
                    'no_telpon' => $validasiUser['no_telpon'],
                    'role' => $validasiUser['role'],
                ]);

            DB::table('karyawan')
                ->where('id', $request->id)
                ->update([
                    'user_id' => $request->id,

                ]);

            DB::table('karyawan')
                ->where('id', $request->id)
                ->update([
                    'user_id' => $request->id,
                    'divisi' => $validasiKaryawan['divisi'],
                ]);

            DB::table('karyawan')
                ->where('id', $request->id)
                ->update([
                    'user_id' => $request->id,
                    'jabatan' => $validasiKaryawan['jabatan'],
                ]);

            DB::table('karyawan')
                ->where('id', $request->id)
                ->update([
                    'user_id' => $request->id,
                    'jumlah_cuti' => $validasiKaryawan['jumlah_cuti'],
                ]);
        } elseif ($request->password == '') {
            $validasiUser = $request->validate([
                'name' => ['required', 'max:255'],
                'nik' => ['required', 'max:16', 'min:16'],
                'email' => ['email'],
                // 'password' => ['required', 'confirmed', 'min:6'],
                'no_telpon' => ['required', 'max:13', 'min:12'],
                'role' => ['required'],
            ]);

            $validasiKaryawan = $request->validate([
                'divisi' => ['required'],
                'jabatan' => ['required'],
                'jumlah_cuti' => ['required', 'max:2', 'min:1'],
            ]);

            // $validasiUser['password'] = Hash::make($validasiUser['password']);

            DB::table('users')
                ->where('id', $request->id)
                ->update([
                    'name' => $validasiUser['name'],
                    'nik' => $validasiUser['nik'],
                    'email' => $validasiUser['email'],
                    // 'password' => $validasiUser['password'],
                    'no_telpon' => $validasiUser['no_telpon'],
                    'role' => $validasiUser['role'],
                ]);

            DB::table('karyawan')
                ->where('id', $request->id)
                ->update([
                    'user_id' => $request->id,

                ]);

            DB::table('karyawan')
                ->where('id', $request->id)
                ->update([
                    'user_id' => $request->id,
                    'divisi' => $validasiKaryawan['divisi'],
                ]);

            DB::table('karyawan')
                ->where('id', $request->id)
                ->update([
                    'user_id' => $request->id,
                    'jabatan' => $validasiKaryawan['jabatan'],
                ]);

            DB::table('karyawan')
                ->where('id', $request->id)
                ->update([
                    'user_id' => $request->id,
                    'jumlah_cuti' => $validasiKaryawan['jumlah_cuti'],
                ]);
        }

        return redirect()->route('karyawan.index')->with(['success' => 'Data Karyawan Berhasil Diupdate!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        DB::table('karyawan')
            ->where('user_id', $id)
            ->delete();

        $user->delete();

        return redirect()->route('karyawan.index')->with(['success' => 'Data Karyawan Berhasil Dihapus!']);
    }
}
