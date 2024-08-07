<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\KategoriPengaduan;
use App\Models\MasalahPengaduan;
use App\Models\Pengaduan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WargaLandingPengaduanController extends Controller
{
    public function index()
    {
        $kategoris = KategoriPengaduan::latest()->get();
        return view('warga.pengaduan.index', [
            'kategoris' => $kategoris,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => 'required',
            'masalah_id' => 'required',
            'judul' => 'required|max:255',
            'lokasi' => 'required',
            'isi_pengaduan' => 'required',
            'tgl_pengaduan' => 'required',
        ], [
            'kategori_id.required' => 'Kategori Pengaduan wajib diisi',
            'masalah_id.required' => 'Masalah Pengaduan wajib diisi',
            'judul.required' => 'Judul Pengaduan wajib diisi',
            'lokasi.required' => 'Lokasi Pengaduan wajib diisi',
            'isi_pengaduan.required' => 'Isi Pengaduan wajib diisi',
            'tgl_pengaduan.required' => 'Tanggal Pengaduan wajib diisi',
        ]);

        $tglPengaduan = Carbon::parse($request->tgl_pengaduan)->format('dmY');

        // Kode
        $validated['kode'] = $tglPengaduan . mt_rand('0', '100');
        $validated['warga_id'] = Auth::user()->warga_id;
        $validated['statuspengaduan'] = 'Belum Tervalidasi';

        // Foto Pengaduan (optional)
        if ($request->file('foto_pengaduan')) {
            $validated['foto_pengaduan'] = $request->file('foto_pengaduan')->store('foto_pengaduan');
        } else {
            $validated['foto_pengaduan'] = null;
        }

        Pengaduan::create($validated);

        return redirect()->route('warga-laporan.index', ['#laporan'])->with('success', 'Selamat ! Anda berhasil memberikan laporan pengaduan, laporan anda segera kami proses!');
    }

    public function getMasalahPengaduanByKategori($id)
    {
        $masalahs = MasalahPengaduan::where('kategori_id', $id)->get();
        return response()->json($masalahs);
    }
}
