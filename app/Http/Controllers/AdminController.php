<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Auth;
use PDF;
use App\uploadpdf;
set_time_limit(1800);

class AdminController extends Controller
{

    public function pengajuan(Request $request)
    {
        $id = Auth()->user()->instansi_id;
        if ($request->has('tanggal')) {
            $pdf = uploadpdf::where('instansi_id', $id)->where('tanggal', 'LIKE', '%' . $request->tanggal . '%')->get();
        } else if ($request->has('nama')) {
            $pdf = uploadpdf::where('instansi_id', $id)->where('nama', 'LIKE', '%' . $request->nama . '%')->get();
        } else {
            $pdf = uploadpdf::all()->where('instansi_id', $id);
        }
        return view('master_adm.pengajuan_index', ['data_pdf' => $pdf]);
    }

    public function uploadpdf(Request $request)
    {
        $file = $request->pdf;
        $namaFile = time() . rand(100, 999) . "." . $file->getClientOriginalExtension();
        //save dokumen pada public path
        $file->move(public_path() . '/pdf', $namaFile);

        //save ke database
        $data = new uploadpdf;
        $data->nama = $request->nama;
        $data->tanggal = $request->tanggal;
        $data->pdf = $namaFile;
        $data->status = 'Menunggu Verifikasi';
        $data->instansi_id = Auth()->user()->instansi_id;
        $data->save();
        return redirect()->route('adm-pengajuan')->with('Sukses', 'Data Berhasil Diinput');
    }

    public function viewupdate($id)
    {
        $data = uploadpdf::find($id);
        return view('master_adm.viewupdate', compact('data'));
    }

    public function updatepdf(Request $request, $id)
    {
        $data = uploadpdf::find($id);

        //delete previous
        $path = public_path('/pdf' . '/' . $data->pdf);
        File::delete($path);
        if (Storage::disk('public')->exists($data->pdf)) {
            Storage::delete('public/'.$data->pdf);
        }
        $file = $request->pdf;
        //save dokumen ke public path
        $namaFile = time() . rand(100, 999) . "." . $file->getClientOriginalExtension();
        $file->move(public_path() . '/pdf', $namaFile);
        
        //update database
        $data->nama = $request->nama;
        $data->tanggal = $request->tanggal;
        $data->pdf = $namaFile;
        $data->status = 'Menunggu Verifikasi';
        $data->save();

        return redirect()->route('adm-pengajuan')->with('Sukses', 'Data Berhasil Diubah');
    }
    public function deletepdf($id)
    {
        $data = uploadpdf::find($id);
        $path = public_path('/pdf' . '/' . $data->pdf);
        File::delete($path);
        if (Storage::disk('public')->exists($data->pdf)) {
            Storage::delete('public/'.$data->pdf);
        }
        $data->delete($data);
        return redirect()->back()->with('Sukses', 'Data Berhasil Dihapus');
    }

    public function download_index(Request $request)
    {
        $id = Auth()->user()->instansi_id;
        if ($request->has('tanggal')) {
            $pdf = uploadpdf::where('instansi_id', $id)->where('status', 'Dokumen Disetujui')
                ->where('tanggal', 'LIKE', '%' . $request->tanggal . '%')->get();
        } else if ($request->has('nama')) {
            $pdf = uploadpdf::where('instansi_id', $id)->where('status', 'Dokumen Disetujui')
                ->where('nama', 'LIKE', '%' . $request->nama . '%')->get();
        } else {
            $pdf = uploadpdf::all()->where('instansi_id', $id)->where('status', 'Dokumen Disetujui');
        }
        return view('master_adm.download_index', ['data_pdf' => $pdf]);
    }

    public function download_bsre($id)
    {
        $data = uploadpdf::find($id);
        return Storage::download('public/'.substr($data->pdf,0,-4).'_sign'.'.pdf');
    }

    public function statistik(Request $request)
    {
        $status = ['Menunggu Verifikasi', 'Memerlukan Revisi', 'Dokumen Disetujui'];
        if ($request->has('tanggal')) {
            $setuju = uploadpdf::where('instansi_id', '=', auth()->user()->instansi->id)
                ->where('status', '=', 'Dokumen Disetujui')
                ->where('tanggal', 'LIKE', '%' . $request->tanggal . '%')->count();
            $revisi = uploadpdf::where('instansi_id', '=', auth()->user()->instansi->id)
                ->where('status', '=', 'Memerlukan Revisi')
                ->where('tanggal', 'LIKE', '%' . $request->tanggal . '%')->count();
            $menunggu = uploadpdf::where('instansi_id', '=', auth()->user()->instansi->id)
                ->where('status', '=', 'Menunggu Verifikasi')
                ->where('tanggal', 'LIKE', '%' . $request->tanggal . '%')->count();
            $now = $request->tanggal;
            return view('master_adm.statistik', compact('status', 'setuju', 'revisi', 'menunggu', 'now'));
        } else {
            $now = Carbon::now()->format('F Y');
            $setuju = uploadpdf::where('instansi_id', '=', auth()->user()->instansi->id)
                ->where('status', '=', 'Dokumen Disetujui')
                ->where('tanggal', 'LIKE', '%' . $now . '%')->count();
            $revisi = uploadpdf::where('instansi_id', '=', auth()->user()->instansi->id)
                ->where('status', '=', 'Memerlukan Revisi')
                ->where('tanggal', 'LIKE', '%' . $now . '%')->count();
            $menunggu = uploadpdf::where('instansi_id', '=', auth()->user()->instansi->id)
                ->where('status', '=', 'Menunggu Verifikasi')
                ->where('tanggal', 'LIKE', '%' . $now . '%')->count();
            return view('master_adm.statistik', compact('status', 'setuju', 'revisi', 'menunggu', 'now'));
        }
    }

    public function cek_view()
    {
        return view('master_adm.cekdokumen');
    }

    public function cek_dokumen(Request $request)
    {
        $file = $request->pdf;
        $response = Http::withBasicAuth('docusign', '1234!@#$')
            ->attach('signed_file', file_get_contents($file->path()), $file->getClientOriginalName())
            ->post('http://103.211.82.154/api/sign/verify');
        // dd($response['jumlah_signature']);
        if ($response['jumlah_signature'] != 0) {
            return redirect()->back()->with('Sukses', Arr::get($response->json(), 'notes'))
                ->with('Signer', Arr::get($response->json(), 'details')[0]['info_signer'])
                ->with('Name', Arr::get($response->json(), 'nama_dokumen'));
        } else {
            return redirect()->back()->with('Gagal', 'Dokumen tidak memiliki digital signature');
        }
    }
}
