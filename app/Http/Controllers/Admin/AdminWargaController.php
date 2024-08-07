<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Warga;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminWargaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $perPage = $request->input('length', 10);
            $search = $request->input('search', '');

            $query = Warga::orderBy('id', 'desc');

            if ($search) {
                $query->where(function ($query) use ($search) {
                    $query->Where('nik', 'LIKE', "%{$search}%")
                        ->orWhere('nama', 'LIKE', "%{$search}%")
                        ->orWhere('tmp_lahir', 'LIKE', "%{$search}%")
                        ->orWhere('jk', 'LIKE', "%{$search}%")
                        ->orWhere('pekerjaan', 'LIKE', "%{$search}%")
                        ->orWhere('telp', 'LIKE', "%{$search}%")
                        ->orWhere('alamat', 'LIKE', "%{$search}%");
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

        return view('admin.warga.index');
    }

    public function create()
    {
        return view('admin.warga.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|unique:wargas,nik',
            'nama' => 'required',
            'tmp_lahir' => 'required',
            'tgl_lahir' => 'required',
            'jk' => 'required',
            'pekerjaan' => 'required',
            'telp' => 'required',
            'email' => 'required',
            'alamat' => 'required',
        ], [
            'nik.required' => 'No KTP wajib diisi',
            'nik.unique' => 'No KTP sudah tersedia',
            'nama.required' => 'Nama Lengkap wajib diisi',
            'tmp_lahir.required' => 'Tempat Lahir wajib diisi',
            'tgl_lahir.required' => 'Tanggal Lahir wajib diisi',
            'jk.required' => 'Jenis Kelamin wajib diisi',
            'pekerjaan.required' => 'Pekerjaan wajib diisi',
            'telp.required' => 'Nomor Telepon wajib diisi',
            'email.required' => 'Email wajib diisi',
            'alamat.required' => 'Alamat Domisili wajib diisi',
        ]);

        if ($request->file('foto_warga')) {
            $validated['foto_warga'] = $request->file('foto_warga')->store('foto_warga');
        } else {
            $validated['foto_warga'] = null;
        }

        $wargas = Warga::create($validated);

        User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('12345678'),
            'level_id' => '2',
            'telp' => $request->telp,
            'warga_id' => $wargas->id,
        ]);

        return redirect()->route('data-warga.index')->with('success', 'Selamat ! Anda berhasil menambahkan data');
    }

    public function edit($id)
    {
        $wargas = Warga::where('id', $id)->first();
        return view('admin.warga.edit', [
            'wargas' => $wargas,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'tmp_lahir' => 'required',
            'tgl_lahir' => 'required',
            'jk' => 'required',
            'pekerjaan' => 'required',
            'telp' => 'required',
            'alamat' => 'required',
        ], [
            'nama.required' => 'Nama Lengkap wajib diisi',
            'tmp_lahir.required' => 'Tempat Lahir wajib diisi',
            'tgl_lahir.required' => 'Tanggal Lahir wajib diisi',
            'jk.required' => 'Jenis Kelamin wajib diisi',
            'pekerjaan.required' => 'Pekerjaan wajib diisi',
            'telp.required' => 'Nomor Telepon wajib diisi',
            'alamat.required' => 'Alamat Domisili wajib diisi',
        ]);

        $wargas = Warga::where('id', $id)->first();

        if ($request->file('foto_warga')) {
            if ($wargas->foto_warga) {
                Storage::delete($wargas->foto_warga);
            }
            $validated['foto_warga'] = $request->file('foto_warga')->store('foto_warga');
        } else {
            $validated['foto_warga'] = $wargas->foto_warga;
        }

        Warga::where('id', $id)->update($validated);

        return redirect()->route('data-warga.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data');
    }

    public function destroy($id)
    {
        $wargas = Warga::where('id', $id)->first();
        if ($wargas->foto_warga) {
            Storage::delete($wargas->foto_warga);
        }
        $wargas->delete();

        return redirect()->route('data-warga.index')->with('success', 'Selamat ! Anda berhasil menghapus data');
    }
}
