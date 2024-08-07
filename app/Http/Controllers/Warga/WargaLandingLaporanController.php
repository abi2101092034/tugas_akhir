<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Komentar;
use App\Models\Pengaduan;
use App\Models\Tanggapan;
use App\Models\Warga;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WargaLandingLaporanController extends Controller
{
    public function index()
    {
        // Fetch the user’s 'warga' record
        $wargas = Warga::where('id', Auth::user()->warga_id)->first();

        // Fetch pengaduans related to the user's 'warga'
        $pengaduans = Pengaduan::where('warga_id', $wargas->id)->latest()->get();

        // Extract IDs of all pengaduan
        $pengaduanIds = $pengaduans->pluck('id');

        // Fetch comments and responses based on the pengaduan IDs
        $komentars = Komentar::whereIn('pengaduan_id', $pengaduanIds)->latest()->get();
        $tanggapans = Tanggapan::whereIn('pengaduan_id', $pengaduanIds)->latest()->get();

        // Pass data to the view
        return view('warga.laporan.index', [
            'pengaduans' => $pengaduans,
            'komentars' => $komentars,
            'tanggapans' => $tanggapans,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'isi_pengaduan' => 'required'
        ]);

        Pengaduan::where('id', $id)->update($validated);

        return redirect()->route('warga-laporan.index')->with('success', 'Selamat ! Anda berhasil memparbaharui laporan anda');
    }

    public function komentar(Request $request)
    {
        $validated = $request->validate([
            'isi_komentar' => 'required',
        ]);

        $pengaduans = Pengaduan::where('id', $request->pengaduan_id)->first();
        Komentar::create([
            'pengaduan_id' => $pengaduans->id,
            'warga_id' => Auth::user()->warga_id,
            'kodepengaduan' => $pengaduans->kode,
            'tgl_komentar' => Carbon::now()->toDateString(),
            'isi_komentar' => $request->isi_komentar ?? '-',
        ]);

        return back();
    }
}
