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
        ->join('karyawan','users.id','=','karyawan.user_id')
        ->select('users.name','users.role','users.email','users.nik','karyawan.user_id','karyawan.id','users.password','users.no_telpon','karyawan.jumlah_cuti','karyawan.jabatan','karyawan.divisi')
        ->get();
        
        return view('pages.karyawan.index',['karyawan' =>$karyawan]);
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

        return view('pages.karyawan.FormCreate',['divisi'=>$divisi, 'jabatan'=>$jabatan, 'role'=>$role]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

        $validasiUser = $request->validate([
            'name' => ['required', 'max:255'],
            'nik' => ['required', 'max:16', 'min:16'],
            'email' => ['unique:users,email'],
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

        // User::create($validasiUser);

        // Karyawan::create($validasiKaryawan);

        $user = User::create($validasiUser);
        $user->karyawan()->create($validasiKaryawan);

        return redirect()->route('karyawan.index')->with(['success' => 'Data Karyawan Berhasil Ditambahkan!']);
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
        ->join('karyawan','users.id','=','karyawan.user_id')
        ->select('users.name','users.nik','users.email','karyawan.id','users.no_telpon','users.password','users.email','karyawan.jumlah_cuti')
        ->where('karyawan.id',$id)
        ->get();

        $divisi = Divisi::all();
        $jabatan = Jabatan::all();
        $role = Role::all();

        return view('pages.karyawan.FormEdit',['karyawan' => $karyawan,'divisi'=>$divisi, 'jabatan'=>$jabatan, 'role'=>$role]);
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
        $dataPassword = Hash::make(($request->password));

        DB::table('users')
            ->where('id', $request->id)
            ->update([
                'email' => $request->email,
                'password' => $dataPassword,
                'no_telpon' => $request->no_telpon,
            ]);
            
            // return view('karyawan.editUser')->with(['success' => 'Data Karyawan Berhasil Diupdate!']);

            return redirect()->route('karyawan.editUser')->with(['success' => 'Data Profil Kamu Berhasil Diupdate!']);
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
        DB::table('users')
            ->where('id', $request->id)
            ->update([
                'name' => $request->name, 
                'nik' => $request->nik,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'no_telpon' => $request->no_telpon,
                'role' => $request->nama_role,
            ]);
        
        DB::table('karyawan')
            ->where('id',$request->id)
            ->update([
                'user_id' => $request->id,
                
        ]);

        DB::table('karyawan')
        ->where('id',$request->id)
        ->update([
            'user_id' => $request->id,
            'divisi' => $request->divisi,
        ]);

        DB::table('karyawan')
            ->where('id',$request->id)
            ->update([
                'user_id' => $request->id,
                'jabatan' => $request->jabatan,
        ]);

        DB::table('karyawan')
        ->where('id',$request->id)
        ->update([
            'user_id' => $request->id,
            'jumlah_cuti' => $request->jumlah_cuti,
        ]);

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
        ->where('user_id',$id)
        ->delete();

        $user->delete();

        return redirect()->route('karyawan.index')->with(['success' => 'Data Karyawan Berhasil Dihapus!']);
    }
}
