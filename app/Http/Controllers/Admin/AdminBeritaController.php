<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminBeritaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $perPage = $request->input('length', 10);
            $search = $request->input('search', '');

            $query = Berita::with('kategori')->orderBy('id', 'desc');

            if ($search) {
                $query->where(function ($query) use ($search) {
                    $query->Where('tgl_berita', 'LIKE', "%{$search}%")
                        ->orWhere('judul_berita', 'LIKE', "%{$search}%")
                        ->orWhere('isi_berita', 'LIKE', "%{$search}%");
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

        return view('admin.berita.index');
    }

    public function create()
    {
        $kategoris = KategoriBerita::latest()->get();
        return view('admin.berita.create', [
            'kategoris' => $kategoris,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => 'required',
            'tgl_berita' => 'required',
            'judul_berita' => 'required',
            'isi_berita' => 'required',
        ], [
            'kategori_id.required' => 'Kategori Berita wajib diisi',
            'tgl_berita.required' => 'Tanggal Berita wajib diisi',
            'judul_berita.required' => 'Judul Berita wajib diisi',
            'isi_berita.required' => 'Isi Berita wajib diisi',
        ]);

        if ($request->file('foto_berita')) {
            $validated['foto_berita'] = $request->file('foto_berita')->store('foto_berita');
        } else {
            $validated['foto_berita'] = null;
        }

        Berita::create($validated);

        return redirect()->route('data-berita.index')->with('success', 'Selamat ! Anda berhasil menambahkan data');
    }

    public function edit($id)
    {
        $kategoris = KategoriBerita::latest()->get();
        $beritas = Berita::where('id', $id)->first();
        return view('admin.berita.edit', [
            'beritas' => $beritas,
            'kategoris' => $kategoris,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kategori_id' => 'required',
            'tgl_berita' => 'required',
            'judul_berita' => 'required',
            'isi_berita' => 'required',
        ], [
            'kategori_id.required' => 'Kategori Berita wajib diisi',
            'tgl_berita.required' => 'Tanggal Berita wajib diisi',
            'judul_berita.required' => 'Judul Berita wajib diisi',
            'isi_berita.required' => 'Isi Berita wajib diisi',
        ]);

        $beritas = Berita::where('id', $id)->first();

        if ($request->file('foto_berita')) {
            if ($beritas->foto_berita) {
                Storage::delete($beritas->foto_berita);
            }
            $validated['foto_berita'] = $request->file('foto_berita')->store('foto_berita');
        } else {
            $validated['foto_berita'] = $beritas->foto_berita;
        }

        $beritas->update($validated);

        return redirect()->route('data-berita.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data');
    }

    public function destroy($id)
    {
        $beritas = Berita::where('id', $id)->first();
        $beritas->delete();

        return redirect()->route('data-berita.index')->with('success', 'Selamat ! Anda berhasil menghapus data');
    }
}
