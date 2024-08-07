<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Level;
use Illuminate\Http\Request;

class AdminLevelController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $perPage = $request->input('length', 10);
            $search = $request->input('search', '');

            $query = Level::orderBy('id', 'desc');

            if ($search) {
                $query->where(function ($query) use ($search) {
                    $query->Where('id_level', 'LIKE', "%{$search}%")
                        ->orWhere('namalevel', 'LIKE', "%{$search}%");
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

        return view('admin.level.index');
    }

    public function create()
    {
        return view('admin.level.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_level' => 'required',
            'namalevel' => 'required',
        ], [
            'id_level.required' => 'ID Status wajib diisi',
            'namalevel.required' => 'Nama Status Autentikasi wajib diisi'
        ]);

        Level::create($validated);

        return redirect()->route('data-level.index')->with('success', 'Selamat ! Anda berhasil menambahkan data');
    }

    public function edit($id)
    {
        $levels = Level::where('id', $id)->first();
        return view('admin.level.edit', [
            'levels' => $levels,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'id_level' => 'required',
            'namalevel' => 'required',
        ], [
            'id_level.required' => 'ID Status wajib diisi',
            'namalevel.required' => 'Nama Status Autentikasi wajib diisi'
        ]);

        Level::where('id', $id)->update($validated);

        return redirect()->route('data-level.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data');
    }

    public function destroy($id)
    {
        $levels = Level::where('id', $id)->first();
        $levels->delete();

        return redirect()->route('data-level.index')->with('success', 'Selamat ! Anda berhasil menghapus data');
    }
}
