<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\Tanggapan;
use Illuminate\Http\Request;

class AdminTanggapanController extends Controller
{
    public function index(Request $request, $id)
    {
        if ($request->ajax()) {
            $perPage = $request->input('length', 10);
            $search = $request->input('search', '');

            $query = Tanggapan::with('pengaduan')
                ->where('pengaduan_id', $id)
                ->orderBy('id', 'desc');

            if ($search) {
                $query->where(function ($query) use ($search) {
                    $query->Where('tgl_tanggapan', 'LIKE', "%{$search}%")
                        ->orWhere('isi_tanggapan', 'LIKE', "%{$search}%");
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

        $pengaduans = Pengaduan::where('id', $id)->first();

        return view('admin.tanggapan.index', [
            'pengaduans' => $pengaduans
        ]);
    }

    public function create($id)
    {
        $pengaduans = Pengaduan::where('id', $id)->first();
        return view('admin.tanggapan.create', [
            'pengaduans' => $pengaduans,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tgl_tanggapan' => 'required',
            'isi_tanggapan' => 'required',
        ], [
            'tgl_tanggapan.required' => 'Tanggal Tanggapan wajib diisi',
            'isi_tanggapan.required' => 'Isi Tanggapan wajib diisi',
        ]);

        $validated['pengaduan_id'] = $request->pengaduan_id;

        Tanggapan::create($validated);

        return redirect()->route('data-tanggapan.index', $request->pengaduan_id)->with('success', 'Selamat ! Anda berhasil menambahkan data');
    }

    public function edit($id)
    {
        $tanggapans = Tanggapan::where('id', $id)->first();
        return view('admin.tanggapan.edit', [
            'tanggapans' => $tanggapans,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tgl_tanggapan' => 'required',
            'isi_tanggapan' => 'required',
        ], [
            'tgl_tanggapan.required' => 'Tanggal Tanggapan wajib diisi',
            'isi_tanggapan.required' => 'Isi Tanggapan wajib diisi',
        ]);

        $validated['pengaduan_id'] = $request->pengaduan_id;

        Tanggapan::where('id', $id)->update($validated);

        return redirect()->route('data-tanggapan.index', $request->pengaduan_id)->with('success', 'Selamat ! Anda berhasil memperbaharui data');
    }

    public function destroy($id)
    {
        $tanggapans = Tanggapan::where('id', $id)->first();
        $tanggapans->delete();

        return back()->with('success', 'Selamat ! Anda berhasil menghapus data');
    }
}
