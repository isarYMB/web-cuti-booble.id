<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Divisi;
use App\Models\Jabatan;
use Illuminate\Support\Facades\Hash;
use DB;

class DivisiController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $divisi = DB::table('divisi')
        ->join('jabatan','divisi.id','=','jabatan.id_divisi')
        ->select('jabatan.nama_jabatan','jabatan.id','jabatan.id_divisi','divisi.nama_divisi')
        ->orderBy('divisi.nama_divisi')
        ->get();

        $divisiAll = DB::table('divisi')
        ->select('divisi.id','divisi.nama_divisi')
        ->get();

        $jabatanAll = DB::table('divisi')
        ->select('divisi.id','divisi.nama_divisi')
        ->get();
        
        return view('pages.divisi.index',['divisi' =>$divisi, 'divisiAll' =>$divisiAll]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function storeDivisi(Request $request)
    {
        $validasiDivisi = [
            'nama_divisi' => $request->nama_divisi,
        ];

        Divisi::create($validasiDivisi);

        return redirect()->route('divisi.index')->with(['success' => 'Data Divisi Berhasil Ditambahkan!']);
    }

    public function storeJabatan(Request $request)
    {

        $validasiJabatan = [
            'nama_jabatan' => $request->nama_jabatan,
            'id_divisi' => $request->id_divisi,
        ];

        Jabatan::create($validasiJabatan);

        return redirect()->route('divisi.index')->with(['success' => 'Data Jabatan Berhasil Ditambahkan!']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroyJabatan($id)
    {

        $jabatan = Jabatan::findOrFail($id);

        $jabatan->delete();

        return redirect()->route('divisi.index')->with(['success' => 'Jabatan Berhasil Dihapuskan!']);
    }
}


