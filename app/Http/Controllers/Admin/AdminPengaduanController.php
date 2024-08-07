<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriPengaduan;
use App\Models\MasalahPengaduan;
use App\Models\Pengaduan;
use App\Models\User;
use App\Models\Warga;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPengaduanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $perPage = $request->input('length', 10);
            $search = $request->input('search', '');

            $query = Pengaduan::with('kategori')
                ->with('masalah')
                ->with('warga')
                ->where('statuspengaduan', 'Belum Tervalidasi')
                ->orderBy('id', 'desc');

            if ($search) {
                $query->where(function ($query) use ($search) {
                    $query->Where('judul', 'LIKE', "%{$search}%")
                        ->orWhere('kode', 'LIKE', "%{$search}%")
                        ->orWhere('judul', 'LIKE', "%{$search}%")
                        ->orWhere('lokasi', 'LIKE', "%{$search}%")
                        ->orWhere('isi_pengaduan', 'LIKE', "%{$search}%")
                        ->orWhere('tgl_pengaduan', 'LIKE', "%{$search}%")
                        ->orWhere('statuspengaduan', 'LIKE', "%{$search}%");
                });
            }

            $totalRecords = $query->count(); // Hitung total data

            $data = $query->paginate($perPage); // Gunakan paginate() untuk membagi data sesuai dengan halaman dan jumlah per halaman

            return response()->json([
                'draw' => $request->input('draw'), // Ambil nomor draw dari permintaan
                'recordsTotal' => $totalRecords, // Kirim jumlah total data
                'recordsFiltered' => $totalRecords, // Jumlah data yang difilter sama dengan jumlah total
                'data' => $data->items(), // Kirim data yang sesuai dengan halaman dan jumlah per halaman
            ]);
        }

        return view('admin.pengaduan.index');
    }

    public function create()
    {
        $kategoris = KategoriPengaduan::latest()->get();
        $masalahs = MasalahPengaduan::latest()->get();
        $wargas = Warga::latest()->get();
        return view('admin.pengaduan.create', [
            'kategoris' => $kategoris,
            'masalahs' => $masalahs,
            'wargas' => $wargas,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => 'required',
            'masalah_id' => 'required',
            'warga_id' => 'required',
            'judul' => 'required',
            'lokasi' => 'required',
            'isi_pengaduan' => 'required',
            'tgl_pengaduan' => 'required',
            'statuspengaduan' => 'required',
        ], [
            'kategori_id.required' => 'Kategori Pengaduan wajib diisi',
            'masalah_id.required' => 'Masalah Pengaduan wajib diisi',
            'warga_id.required' => 'Warga Pengaduan wajib diisi',
            'judul.required' => 'Judul Pengaduan wajib diisi',
            'lokasi.required' => 'Lokasi Pengaduan wajib diisi',
            'isi_pengaduan.required' => 'Isi Pengaduan wajib diisi',
            'tgl_pengaduan.required' => 'Tanggal Pengaduan wajib diisi',
            'statuspengaduan.required' => 'Status Pengaduan wajib diisi',
        ]);

        $tglPengaduan = Carbon::parse($request->tgl_pengaduan)->format('dmY');

        // Kode
        $validated['kode'] = $tglPengaduan . mt_rand('0', '100');

        // Foto Pengaduan (optional)
        if ($request->file('foto_pengaduan')) {
            $validated['foto_pengaduan'] = $request->file('foto_pengaduan')->store('foto_pengaduan');
        } else {
            $validated['foto_pengaduan'] = null;
        }

        Pengaduan::create($validated);

        return redirect()->route('data-pengaduan.index')->with('success', 'Selamat ! Anda berhasil menambahkan data');
    }

    public function edit($id)
    {
        $kategoris = KategoriPengaduan::latest()->get();
        $masalahs = MasalahPengaduan::latest()->get();
        $wargas = Warga::latest()->get();
        $pengaduans = Pengaduan::where('id', $id)->first();
        return view('admin.pengaduan.edit', [
            'kategoris' => $kategoris,
            'masalahs' => $masalahs,
            'wargas' => $wargas,
            'pengaduans' => $pengaduans,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kategori_id' => 'required',
            'masalah_id' => 'required',
            'warga_id' => 'required',
            'judul' => 'required',
            'lokasi' => 'required',
            'isi_pengaduan' => 'required',
            'tgl_pengaduan' => 'required',
            'statuspengaduan' => 'required',
        ], [
            'kategori_id.required' => 'Kategori Pengaduan wajib diisi',
            'masalah_id.required' => 'Masalah Pengaduan wajib diisi',
            'warga_id.required' => 'Warga Pengaduan wajib diisi',
            'judul.required' => 'Judul Pengaduan wajib diisi',
            'lokasi.required' => 'Lokasi Pengaduan wajib diisi',
            'isi_pengaduan.required' => 'Isi Pengaduan wajib diisi',
            'tgl_pengaduan.required' => 'Tanggal Pengaduan wajib diisi',
            'statuspengaduan.required' => 'Status Pengaduan wajib diisi',
        ]);

        $pengaduans = Pengaduan::where('id', $id)->first();
        // Foto Pengaduan (optional)
        if ($request->file('foto_pengaduan')) {
            if ($pengaduans->foto_pengaduan) {
                Storage::delete($pengaduans->foto_pengaduan);
            }
            $validated['foto_pengaduan'] = $request->file('foto_pengaduan')->store('foto_pengaduan');
        } else {
            $validated['foto_pengaduan'] = $pengaduans->foto_pengaduan;
        }

        Pengaduan::where('id', $id)->update($validated);

        return redirect()->route('data-pengaduan.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data');
    }

    public function show($id)
    {
        return view('admin.pengaduan.show', [
            'pengaduans' => Pengaduan::where('id', $id)->first(),
        ]);
    }

    public function destroy($id)
    {
        $pengaduans = Pengaduan::where('id', $id)->first();
        $pengaduans->delete();

        return redirect()->route('data-pengaduan.index')->with('success', 'Selamat ! Anda berhasil menghapus data');
    }

    public function getMasalahPengaduanByKategori($id)
    {
        $masalahs = MasalahPengaduan::where('kategori_id', $id)->get();
        return response()->json($masalahs);
    }

    public function sudahtervalidasi($id)
    {
        $pengaduans = Pengaduan::where('id', $id)->first();
        $pengaduans->update([
            'statuspengaduan' => 'Sudah Tervalidasi'
        ]);

        return redirect()->route('data-pengaduan.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data');
    }

    public function belumtervalidasi($id)
    {
        $pengaduans = Pengaduan::where('id', $id)->first();
        $pengaduans->update([
            'statuspengaduan' => 'Belum Tervalidasi'
        ]);

        return redirect()->route('data-pengaduan.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data');
    }

    public function ditolak($id)
    {
        $pengaduans = Pengaduan::where('id', $id)->first();
        $pengaduans->update([
            'statuspengaduan' => 'Ditolak'
        ]);

        return redirect()->route('data-pengaduan.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data');
    }

    function selesai($id)
    {
        $pengaduans = Pengaduan::where('id', $id)->first();
        $pengaduans->update([
            'status' => 'selesai'
        ]);
        return redirect()->route('data-pengaduan.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data');
    }

    public function dikerjakan($id)
    {
        $pengaduans = Pengaduan::where('id', $id)->first();
        $pengaduans->update([
            'statuspengaduan' => 'Dikerjakan'
        ]);
        return redirect()->route('data-pengaduan.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data');
    }
}
