<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $perPage = $request->input('length', 10);
            $search = $request->input('search', '');

            $query = User::with('level')->orderBy('id', 'desc');

            if ($search) {
                $query->where(function ($query) use ($search) {
                    $query->Where('name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%")
                        ->orWhere('level_id', 'LIKE', "%{$search}%")
                        ->orWhere('telp', 'LIKE', "%{$search}%");
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

        return view('admin.users.index');
    }

    public function create()
    {
        $levels = Level::latest()->get();
        return view('admin.users.create', [
            'levels' => $levels,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'level_id' => 'required',
            'telp' => 'required',
        ], [
            'name.required' => 'Nama Lengkap wajib diisi',
            'email.required' => 'Email Address wajib diisi',
            'email.unique' => 'Email Address sudah tersedia',
            'level_id.required' => 'Status Autentikasi wajib diisi',
            'telp.required' => 'Nomor Telepon wajib diisi',
        ]);

        $validated['password'] = bcrypt('12345678');
        $validated['email_verified_at'] = Carbon::now();

        User::create($validated);

        return redirect()->route('data-user.index')->with('success', 'Selamat ! Anda berhasil menambahkan data');
    }

    public function edit($id)
    {
        $levels = Level::latest()->get();
        $users = User::where('id', $id)->first();
        return view('admin.users.edit', [
            'users' => $users,
            'levels' => $levels,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'level_id' => 'required',
            'telp' => 'required',
        ], [
            'name.required' => 'Nama Lengkap wajib diisi',
            'level_id.required' => 'Status Autentikasi wajib diisi',
            'telp.required' => 'Nomor Telepon wajib diisi',
        ]);

        $validated['password'] = bcrypt('12345678');
        $validated['email_verified_at'] = Carbon::now();

        User::where('id', $id)->update($validated);

        return redirect()->route('data-user.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data');
    }

    public function destroy($id)
    {
        $users = User::where('id', $id)->first();
        $users->delete();

        return redirect()->route('data-user.index')->with('success', 'Selamat ! Anda berhasil menghapus data');
    }
}
