<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriPengaduan;
use App\Models\MasalahPengaduan;
use Illuminate\Http\Request;

class AdminMasalahPengaduanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $perPage = $request->input('length', 10);
            $search = $request->input('search', '');

            $query = MasalahPengaduan::with('kategori')->orderBy('id', 'desc');

            if ($search) {
                $query->where(function ($query) use ($search) {
                    $query->Where('kode', 'LIKE', "%{$search}%")
                        ->orWhere('nama', 'LIKE', "%{$search}%");
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

        return view('admin.masalah-pengaduan.index');
    }

    public function create()
    {
        $kategoris = KategoriPengaduan::latest()->get();
        return view('admin.masalah-pengaduan.create', [
            'kategoris' => $kategoris,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required',
            'kategori_id' => 'required',
            'nama' => 'required',
        ], [
            'kode.required' => 'Kode Masalah Pengaduan wajib diisi',
            'kategori_id.required' => 'Kategori Pengaduan wajib diisi',
            'nama.required' => 'Nama Masalah Pengaduan wajib diisi',
        ]);

        MasalahPengaduan::create($validated);

        return redirect()->route('data-masalahpengaduan.index')->with('success', 'Selamat ! Anda berhasil menambahkan data');
    }

    public function edit($id)
    {
        $masalahs = MasalahPengaduan::where('id', $id)->first();
        $kategoris = KategoriPengaduan::latest()->get();
        return view('admin.masalah-pengaduan.edit', [
            'kategoris' => $kategoris,
            'masalahs' => $masalahs
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kode' => 'required',
            'kategori_id' => 'required',
            'nama' => 'required',
        ], [
            'kode.required' => 'Kode Masalah Pengaduan wajib diisi',
            'kategori_id.required' => 'Kategori Pengaduan wajib diisi',
            'nama.required' => 'Nama Masalah Pengaduan wajib diisi',
        ]);

        MasalahPengaduan::where('id', $id)->update($validated);

        return redirect()->route('data-masalahpengaduan.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data');
    }

    public function destroy($id)
    {
        $masalahs = MasalahPengaduan::where('id', $id)->first();
        $masalahs->delete();

        return redirect()->route('data-masalahpengaduan.index')->with('success', 'Selamat ! Anda berhasil menghapus data');
    }
}
