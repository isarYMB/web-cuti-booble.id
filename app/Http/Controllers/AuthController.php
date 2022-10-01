<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Hash;
use Session;

class AuthController extends Controller
{
    public function showFormLogin()
    {
        if (Auth::check()) { // true sekalian session field di users nanti bisa dipanggil via Auth
            //Login Success
            if(Auth::user()->role === 'karyawan'){
                return redirect()->route('karyawan.dashboard');
            }elseif(Auth::user()->role === 'HRD'){
                return redirect()->route('admin.dashboard');
            }elseif(Auth::user()->role === 'Leader'){
                return redirect()->route('permohonan.index'); 
            }elseif(Auth::user()->role === 'Kepala Divisi'){
                return redirect()->route('kadivisi.dashboard');
            }
            
        }
        return view('pages.auth.login');
    }

    public function login(Request $request)
    {
        $rules = [
            'email'                 => 'required|email',
            'password'              => 'required|string'
        ];

        $messages = [
            'email.required'        => 'Email wajib diisi',
            'email.email'           => 'Email tidak valid',
            'password.required'     => 'Password wajib diisi',
            'password.string'       => 'Password harus berupa string'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $data = [
            'email'     => $request->input('email'),
            'password'  => $request->input('password'),
        ];

        Auth::attempt($data);

        if (Auth::check()) { // true sekalian session field di users nanti bisa dipanggil via Auth
            
            //Login Success
            if(Auth::user()->role === 'karyawan'){
                return redirect()->route('karyawan.dashboard');
            }elseif(Auth::user()->role === 'HRD'){
                return redirect()->route('admin.dashboard');
            }elseif(Auth::user()->role === 'Leader'){
                return redirect()->route('permohonan.index'); 
            }elseif(Auth::user()->role === 'Kepala Divisi'){
                return redirect()->route('kadivisi.dashboard');
            }
        } else { // false

            //Login Fail
            Session::flash('error', 'Email atau password salah');
            return redirect()->route('login');
        }

    }
    public function logout()
    {
        Auth::logout(); // menghapus session yang aktif
        return redirect()->route('login');
    }
}
