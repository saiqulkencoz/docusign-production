<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Auth;
use File;
use App\uploadpdf;

set_time_limit(1800);

class KadisController extends Controller
{
    public function index(Request $request)
    {
        $id = Auth()->user()->instansi_id;
        if ($request->has('tanggal')) {
            $pdf = uploadpdf::where('instansi_id', $id)->where('tanggal', 'LIKE', '%' . $request->tanggal . '%')->get();
        } else if ($request->has('nama')) {
            $pdf = uploadpdf::where('instansi_id', $id)->where('nama', 'LIKE', '%' . $request->nama . '%')->get();
        } else {
            $pdf = uploadpdf::all()->where('instansi_id', $id);
        }
        return view('kadis.dokumen', ['data_pdf' => $pdf]);
    }

    public function terima(Request $request, $id)
    {
        $dokumen = uploadpdf::find($id);
        $path = public_path('/pdf' . '/' . $dokumen->pdf);

        //e-sign process
        $sign = Http::withBasicAuth('docusign', '1234!@#$')
            ->attach(
                'file',
                file_get_contents($path),
                $dokumen->pdf
            )
            ->post('http://103.211.82.154/api/sign/pdf', [
                'nik' => Auth()->user()->nik,
                'passphrase' => $request->pass_bsre,
                'tampilan' => 'visible',
                'halaman' => 'terakhir',
                'image' => 'false',
                'linkQR' => 'https://docusign.batukota.go.id/storage/'.substr($dokumen->pdf,0,-4).'_sign'.'.pdf',
                'xAxis' => '-50',
                'yAxis' => '50',
                'width' => '350',
                'height' => '150',
            ]);
        // dd($sign->json());    
        if ($sign->status()==200) {
            //save hasil e-sign
            $response = Http::withBasicAuth('docusign', '1234!@#$')
                ->get('http://103.211.82.154/api/sign/download/' . $sign->headers()['id_dokumen']['0']);
            $filename = substr($dokumen->pdf,0,-4).'_sign'.'.pdf';
            Storage::disk('public')->put($filename, $response);
            $response->move(public_path() . '/storage', $filename);
            $dokumen->status = 'Dokumen Disetujui';
            $dokumen->save();
            return redirect()->back()->with('Sukses', 'Dokumen sudah terverifikasi');
        } else {
            return redirect()->back()->with('Gagal', 'Proses signing gagal : Passphrase BSRE anda salah');
        }
    }

    public function tolak(Request $request, $id)
    {
        $dokumen = uploadpdf::find($id);
        $dokumen->status = 'Memerlukan Revisi';
        $dokumen->note = $request->note;
        $dokumen->save();
        return redirect()->back()->with('Sukses', 'Dokumen sudah dikembalikan untuk revisi');
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
            return view('kadis.statistik', compact('status', 'setuju', 'revisi', 'menunggu', 'now'));
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
            return view('kadis.statistik', compact('status', 'setuju', 'revisi', 'menunggu', 'now'));
        }
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
        return view('kadis.download_index', ['data_pdf' => $pdf]);
    }

    public function download_bsre($id)
    {
        $data = uploadpdf::find($id);
        return Storage::download('public/'.substr($data->pdf,0,-4).'_sign'.'.pdf');
    }
}
