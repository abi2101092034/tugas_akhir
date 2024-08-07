<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Warga;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|unique:wargas,nik',
            'nama' => 'required',
            'tmp_lahir' => 'required',
            'tgl_lahir' => 'required|date',
            'jk' => 'required',
            'pekerjaan' => 'required',
            'telp' => 'required',
            'alamat' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:8',
            'foto_warga' => 'required|mimes:png,jpeg,jpg',
        ], [
            'nik.required' => 'NIK wajib diisi',
            'nik.unique' => 'NIK sudah tersedia',
            'nama.required' => 'Nama Lengkap wajib diisi',
            'tmp_lahir.required' => 'Tempat Lahir wajib diisi',
            'tgl_lahir.required' => 'Tanggal Lahir wajib diisi',
            'jk.required' => 'Jenis Kelamin wajib diisi',
            'pekerjaan.required' => 'Pekerjaan wajib diisi',
            'telp.required' => 'Nomor Telepon wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.unique' => 'Email sudah tersedia',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'foto_warga.required' => 'Foto Warga wajib diisi',
            'foto_warga.mimes' => 'Foto Warga harus memiliki format PNG, JPEG, atau JPG',
        ]);

        if ($request->file('foto_warga')) {
            $fotoWarga = $request->file('foto_warga')->store('foto_warga');
        }

        $warga = Warga::create([
            'nik' => $validated['nik'],
            'nama' => $validated['nama'],
            'tmp_lahir' => $validated['tmp_lahir'],
            'tgl_lahir' => $validated['tgl_lahir'],
            'jk' => $validated['jk'],
            'pekerjaan' => $validated['pekerjaan'],
            'email' => $validated['email'],
            'telp' => $validated['telp'],
            'alamat' => $validated['alamat'],
            'foto_warga' => $fotoWarga,
        ]);

        $user = User::create([
            'name' => $validated['nama'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'level_id' => '2',
            'telp' => $validated['telp'],
            'warga_id' => $warga->id,
        ]);

        $user->sendEmailVerificationNotification();

        return redirect()->route('verification.notice')->with('success', 'Selamat ! Anda berhasil melakukan registrasi!');
    }

    public function authenticate(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ], [
            'email.required' => 'Email Address wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);

        if (Auth::attempt($validated)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard')->with('success', 'Anda berhasil Login');
        } else {
            return back()->withErrors(['error' => 'Email atau password anda salah']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/');
    }
}
