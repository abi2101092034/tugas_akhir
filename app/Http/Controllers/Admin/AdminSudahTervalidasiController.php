<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;

class AdminSudahTervalidasiController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $perPage = $request->input('length', 10);
            $search = $request->input('search', '');

            $query = Pengaduan::with('kategori')
                ->with('masalah')
                ->with('warga')
                ->where('statuspengaduan', 'Sudah Tervalidasi')
                ->orderBy('id', 'desc');

            if ($search) {
                $query->where(function ($query) use ($search) {
                    $query->Where('judul', 'LIKE', "%{$search}%")
                        ->orWhere('kode', 'LIKE', "%{$search}%")
                        ->orWhere('judul', 'LIKE', "%{$search}%")
                        ->orWhere('lokasi', 'LIKE', "%{$search}%")
                        ->orWhere('isi_pengaduan', 'LIKE', "%{$search}%")
                        ->orWhere('tgl_pengaduan', 'LIKE', "%{$search}%");
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

        return view('admin.sudah-tervalidasi.index');
    }

    public function  show($id)
    {
        return view('admin.sudah-tervalidasi.show', [
            'pengaduans' => Pengaduan::where('id', $id)->first(),
        ]);
    }

    public function destroy($id)
    {
        $pengaduans = Pengaduan::where('id', $id)->first();
        $pengaduans->delete();

        return redirect()->route('data-pengaduan.index')->with('success', 'Selamat ! Anda Berhasil Mengahapus Data');
    }

    public function dikerjakan($id)
    {
        $pengaduans = Pengaduan::where('id', $id)->first();
        $pengaduans->update([
            'statuspengaduan' => 'Dikerjakan'
        ]);
        return back()->with('success', 'Selamat ! Anda berhasil memperbaharui data');
    }
}
