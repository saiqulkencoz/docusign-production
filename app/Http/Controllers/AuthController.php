<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //fungsi untuk menampilkan halaman login ketika route mendapat /login
    public function login(){
        return view('login'); //menampilkan login.blade.php
    }

    //fungsi untuk menangkap dan memproses data login dari user yang dimasukkan
    public function postlogin(Request $request){
        if(Auth::attempt($request->only('nik','password'))){
            if(Auth()->user()->role=="root"){
                return redirect('/super/instansi');
            }
            else if(Auth()->user()->role=="kepala dinas"){
                return redirect('/kadis/dokumen');
            }
            else{
                return redirect('/admin/pengajuan');
            }
        }
        return redirect('/login');
    }

    //fungsi untuk melakukan proses logout
    public function logout (Request $request){
        Auth::logout();
        return redirect('/login'); //mengarahkan user pada halaman login awal
    }
}
