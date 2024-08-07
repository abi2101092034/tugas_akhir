<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Komentar;
use App\Models\Pengaduan;
use App\Models\Warga;
use Illuminate\Http\Request;

class AdminKomentarController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $perPage = $request->input('length', 10);
            $search = $request->input('search', '');

            $query = Komentar::with('pengaduan')->with('warga')->orderBy('id', 'desc');

            if ($search) {
                $query->where(function ($query) use ($search) {
                    $query->Where('kodepengaduan', 'LIKE', "%{$search}%")
                        ->orWhere('tgl_komentar', 'LIKE', "%{$search}%")
                        ->orWhere('isi_komentar', 'LIKE', "%{$search}%");
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

        return view('admin.komentar.index');
    }

    public function create()
    {
        $pengaduans = Pengaduan::orderBy('id', 'desc')->get();
        $wargas = Warga::orderBy('id', 'desc')->get();
        return view('admin.komentar.create', [
            'pengaduans' => $pengaduans,
            'wargas' => $wargas
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pengaduan_id' => 'required',
            'warga_id' => 'required',
            'tgl_komentar' => 'required',
            'isi_komentar' => 'required',
        ], [
            'pengaduan_id.required' => 'Pengaduan wajib diisi',
            'warga_id.required' => 'Warga wajib diisi',
            'tgl_komentar.required' => 'Tanggal Komentar wajib diisi',
            'isi_komentar.required' => 'Keterangan Komentar wajib diisi',
        ]);

        $pengaduans = Pengaduan::where('id', $request->pengaduan_id)->first();

        $validated['kodepengaduan'] = $pengaduans->kode;

        Komentar::create($validated);

        return redirect()->route('data-komentar.index')->with('success', 'Selamat ! Anda berhasil menambahkan data');
    }

    public function edit($id)
    {
        $pengaduans = Pengaduan::orderBy('id', 'desc')->get();
        $wargas = Warga::orderBy('id', 'desc')->get();
        $komentars = Komentar::where('id', $id)->first();
        return view('admin.komentar.edit', [
            'pengaduans' => $pengaduans,
            'wargas' => $wargas,
            'komentars' => $komentars,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'pengaduan_id' => 'required',
            'warga_id' => 'required',
            'tgl_komentar' => 'required',
            'isi_komentar' => 'required',
        ], [
            'pengaduan_id.required' => 'Pengaduan wajib diisi',
            'warga_id.required' => 'Warga wajib diisi',
            'tgl_komentar.required' => 'Tanggal Komentar wajib diisi',
            'isi_komentar.required' => 'Keterangan Komentar wajib diisi',
        ]);

        $pengaduans = Pengaduan::where('id', $request->pengaduan_id)->first();

        $validated['kodepengaduan'] = $pengaduans->kode;

        Komentar::where('id', $id)->update($validated);

        return redirect()->route('data-komentar.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data');
    }

    public function destroy($id)
    {
        $komentars = Komentar::where('id', $id)->first();
        $komentars->delete();

        return redirect()->route('data-komentar.index')->with('success', 'Selamat ! Anda berhasil menghapus data');
    }
}
