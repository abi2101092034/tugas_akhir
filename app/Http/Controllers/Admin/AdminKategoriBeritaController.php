<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;

class AdminKategoriBeritaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $perPage = $request->input('length', 10);
            $search = $request->input('search', '');

            $query = KategoriBerita::orderBy('id', 'desc');

            if ($search) {
                $query->where(function ($query) use ($search) {
                    $query->Where('nama', 'LIKE', "%{$search}%");
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

        return view('admin.kategori-berita.index');
    }

    public function create()
    {
        return view('admin.kategori-berita.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required',
        ], [
            'nama.required' => 'Nama Kategori Berita wajib diisi'
        ]);

        KategoriBerita::create($validated);

        return redirect()->route('data-kategoriberita.index')->with('success', 'Selamat ! Anda berhasil menambahkan data');
    }

    public function edit($id)
    {
        $kategoris = KategoriBerita::where('id', $id)->first();
        return view('admin.kategori-berita.edit', [
            'kategoris' => $kategoris,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required',
        ], [
            'nama.required' => 'Nama Kategori Berita wajib diisi'
        ]);

        KategoriBerita::where('id', $id)->update($validated);

        return redirect()->route('data-kategoriberita.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data');
    }

    public function destroy($id)
    {
        $kategoris = KategoriBerita::where('id', $id)->first();
        $kategoris->delete();

        return redirect()->route('data-kategoriberita.index')->with('success', 'Selamat ! Anda berhasil menghapus data');
    }
}
