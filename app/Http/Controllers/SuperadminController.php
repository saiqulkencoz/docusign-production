<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

use Carbon\Carbon;
use App\Instansi;
use App\uploadpdf;
use App\User;
set_time_limit(1800);

class SuperadminController extends Controller
{
    //indexing atau read
    public function instansi_index(){
        $instansi = Instansi::all();
        return view('master_super.dinas_index',['instansi' => $instansi]); //mengembalikan ke view dengan data
    }
    //membuat data baru
    public function create(Request $request){
        Instansi::create($request->all());
        return redirect()->back()->with('Sukses','Data Berhasil Diinput');
    }
    //indexing data edit
    public function update_index($id){
        $instansi = Instansi::find($id);
        return view('master_super.dinas_update',['instansi' => $instansi]);
    }
    //menyimpan data yang akan diubah
    public function update(Request $request,$id){
        $instansi = Instansi::find($id);
        $instansi->update($request->all());
        return redirect('/super/instansi')->with('Sukses','Data Berhasil Di Update');
    }
    //menghapus data
    public function delete($id){
        $instansi = Instansi::find($id);
        $instansi->delete($instansi);
        return redirect()->back()->with('Sukses','Data Berhasil Dihapus');
    }

    
    public function user_index(){
        $instansi = Instansi::all();
        $user = User::all()->except(1);
        return view('master_super.user_index',['instansi' => $instansi],['user' => $user]);
    }
    
    public function create_user(Request $request){
        $request->merge([
            'password' => bcrypt($request->password),
        ]);
        // dd($request->all());
        User::create($request->all());
        return redirect()->back()->with('Sukses','Data Berhasil Diinput');
    }
    
    public function update_user_index($id){
        $user = User::find($id);
        $instansi = Instansi::all();
        return view('master_super.user_update',['instansi' => $instansi],['user' => $user]);
    }

    public function update_user(Request $request, $id){
        $user = User::find($id);
        $request->request->add(['password'=> $user->password]);
        $user->update($request->all());
        // dd($request->all());
        return redirect('/super/user')->with('Sukses','Data Berhasil Di Update');
    }

    public function delete_user($id){
        $user = User::find($id);
        $user->delete($user);
        return redirect()->back()->with('Sukses','Data Berhasil Dihapus');
    }

    public function statistik(Request $request){
        $status = ['Menunggu Verifikasi','Memerlukan Revisi','Dokumen Disetujui'];
        if($request->has('instansi')&&$request->tanggal==''){
            $now = Carbon::now()->format('F Y');
            $default = Instansi::find($request->instansi);
            $setuju = uploadpdf::where('instansi_id', '=', $request->instansi)
            ->where('status', '=', 'Dokumen Disetujui')
            ->where('tanggal','LIKE','%'.$now.'%')->count();
            $revisi = uploadpdf::where('instansi_id', '=', $request->instansi)
            ->where('status', '=', 'Memerlukan Revisi')
            ->where('tanggal','LIKE','%'.$now.'%')->count();
            $menunggu = uploadpdf::where('instansi_id', '=', $request->instansi)
            ->where('status', '=', 'Menunggu Verifikasi')
            ->where('tanggal','LIKE','%'.$now.'%')->count();
            // dd($request-all());
            $select = Instansi::all();
            return view ('master_super.statistik',compact('status','setuju','revisi','menunggu','default','select','now'));
        }
        else if($request->has('instansi')&&$request->tanggal!=''){
            $now = $request->tanggal;
            $default = Instansi::find($request->instansi);
            $setuju = uploadpdf::where('instansi_id', '=', $request->instansi)
            ->where('status', '=', 'Dokumen Disetujui')
            ->where('tanggal','LIKE','%'.$request->tanggal.'%')->count();
            $revisi = uploadpdf::where('instansi_id', '=', $request->instansi)
            ->where('status', '=', 'Memerlukan Revisi')
            ->where('tanggal','LIKE','%'.$request->tanggal.'%')->count();
            $menunggu = uploadpdf::where('instansi_id', '=', $request->instansi)
            ->where('status', '=', 'Menunggu Verifikasi')
            ->where('tanggal','LIKE','%'.$request->tanggal.'%')->count();
            // dd($request-all());
            $select = Instansi::all();
            return view ('master_super.statistik',compact('status','setuju','revisi','menunggu','default','select','now'));
        }
        else{
            $now = Carbon::now()->format('F Y');
            $default = Instansi::first();
            $setuju = uploadpdf::where('instansi_id', '=', $default->id)
            ->where('status', '=', 'Dokumen Disetujui')
            ->where('tanggal','LIKE','%'.$now.'%')->count();
            $revisi = uploadpdf::where('instansi_id', '=', $default->id)
            ->where('status', '=', 'Memerlukan Revisi')
            ->where('tanggal','LIKE','%'.$now.'%')->count();
            $menunggu = uploadpdf::where('instansi_id', '=', $default->id)
            ->where('status', '=', 'Menunggu Verifikasi')
            ->where('tanggal','LIKE','%'.$now.'%')->count();
            $select = Instansi::all();
            return view ('master_super.statistik',compact('status','setuju','revisi','menunggu','default','select','now'));
        }
    }

    public function cek_view(){
        return view ('master_super.cek_user');
    }

    public function cek_post(Request $request){
        $response = Http::withBasicAuth('test','qwerty')
                    ->get('103.211.82.148/api/user/status/'.$request->nik);
        // dd($response->json());            
        return redirect()->back()->with('Sukses',$response->json())
        ->with('NIK',$request->nik);            
    }
}
