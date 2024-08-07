<?php

use App\Http\Controllers\Admin\AdminBeritaController;
use App\Http\Middleware\CekLevel;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminDitolakController;
use App\Http\Controllers\Admin\AdminKategoriBeritaController;
use App\Http\Controllers\Admin\AdminKategoriPengaduanController;
use App\Http\Controllers\Admin\AdminKomentarController;
use App\Http\Controllers\Admin\AdminLevelController;
use App\Http\Controllers\Admin\AdminMasalahPengaduanController;
use App\Http\Controllers\Admin\AdminPengaduanController;
use App\Http\Controllers\Admin\AdminSelesaiController;
use App\Http\Controllers\Admin\AdminSudahDikerjakanController;
use App\Http\Controllers\Admin\AdminSudahTervalidasiController;
use App\Http\Controllers\Admin\AdminTanggapanController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminWargaController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Landing\LandingController;
use App\Http\Controllers\Warga\WargaInformasiController;
use App\Http\Controllers\Warga\WargaInformasiSimController;
use App\Http\Controllers\Warga\WargaLandingLaporanController;
use App\Http\Controllers\Warga\WargaLandingPengaduanController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// warga Informasi
Route::get('/warga-informasi', [WargaInformasiController::class, 'index'])->name('warga-informasi.index');
Route::get('/warga-informasi-sim', [WargaInformasiSimController::class, 'index'])->name('warga-informasi-sim.index');

// Landing
Route::get('/', [LandingController::class, 'index'])->name('login');
Route::post('/login-action', [AuthController::class, 'authenticate'])->name('login-action.authenticate');
Route::get('/logout-action', [AuthController::class, 'logout'])->name('logout-action.logout');

Route::post('/register-action', [AuthController::class, 'register'])->name('register-action.register');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Tautan verifikasi telah dikirim ulang!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


// Dashboard
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index']);

    // Warga
    Route::get('warga-pengaduan', [WargaLandingPengaduanController::class, 'index'])->name('warga-pengaduan.index');
    Route::get('warga-laporan', [WargaLandingLaporanController::class, 'index'])->name('warga-laporan.index');
    Route::post('warga-laporan/komentar', [WargaLandingLaporanController::class, 'komentar'])->name('warga-laporan.komentar');
    Route::post('warga-laporan/update/{id}', [WargaLandingLaporanController::class, 'update'])->name('warga-laporan.update');
    Route::post('warga-pengaduan/store', [WargaLandingPengaduanController::class, 'store'])->name('warga-pengaduan.store');
    Route::get('/warga-pengaduan/getMasalahPengaduanByKategori/{id}', [WargaLandingPengaduanController::class, 'getMasalahPengaduanByKategori'])->name('warga-pengaduan.getMasalahPengaduanByKategori');

    // Admin
    Route::group(['middleware' => [CekLevel::class . ':1']], function () {

        // Komentar
        Route::get('/data-komentar', [AdminKomentarController::class, 'index'])->name('data-komentar.index');
        Route::get('/data-komentar/create', [AdminKomentarController::class, 'create'])->name('data-komentar.create');
        Route::post('/data-komentar/store', [AdminKomentarController::class, 'store'])->name('data-komentar.store');
        Route::get('/data-komentar/edit/{id}', [AdminKomentarController::class, 'edit'])->name('data-komentar.edit');
        Route::post('/data-komentar/update/{id}', [AdminKomentarController::class, 'update'])->name('data-komentar.update');
        Route::post('/data-komentar/destroy/{id}', [AdminKomentarController::class, 'destroy'])->name('data-komentar.destroy');

        // Ditolak
        Route::get('/data-ditolak', [AdminDitolakController::class, 'index'])->name('data-ditolak.index');

        // Selesai
        Route::get('/data-selesai', [AdminSelesaiController::class, 'index'])->name('data-selesai.index');

        // Sudah Dikerjakan
        Route::get('/data-sudahdikerjakan', [AdminSudahDikerjakanController::class, 'index'])->name('data-sudahdikerjakan.index');
        Route::post('/data-sudahdikerjakan/selesai/{id}', [AdminSudahDikerjakanController::class, 'selesai'])->name('data-sudahdikerjakan.selesai');
        Route::get('/data-sudahdikerjakan/show/{id}', [AdminsudahdikerjakanController::class, 'show'])->name('data-sudahdikerjakan.show');

        // Tanggapan
        Route::get('/data-tanggapan/{id}', [AdminTanggapanController::class, 'index'])->name('data-tanggapan.index');
        Route::get('/data-tanggapan/create/{id}', [AdminTanggapanController::class, 'create'])->name('data-tanggapan.create');
        Route::post('/data-tanggapan/store', [AdminTanggapanController::class, 'store'])->name('data-tanggapan.store');
        Route::get('/data-tanggapan/edit/{id}', [AdminTanggapanController::class, 'edit'])->name('data-tanggapan.edit');
        Route::post('/data-tanggapan/update/{id}', [AdminTanggapanController::class, 'update'])->name('data-tanggapan.update');
        Route::post('/data-tanggapan/destroy/{id}', [AdminTanggapanController::class, 'destroy'])->name('data-tanggapan.destroy');

        // Sudah Tervalidasi
        Route::get('/data-sudahtervalidasi', [AdminSudahTervalidasiController::class, 'index'])->name('data-sudahtervalidasi.index');
        Route::get('/data-sudahtervalidasi/show/{id}', [AdminSudahTervalidasiController::class, 'show'])->name('data-sudahtervalidasi.show');
        Route::post('/data-sudahtervalidasi/dikerjakan/{id}', [AdminSudahTervalidasiController::class, 'dikerjakan'])->name('data-sudahtervalidasi.dikerjakan');
        Route::post('/data-sudahtervalidasi/destroy/{id}', [AdminSudahTervalidasiController::class, 'destroy'])->name('data-sudahtervalidasi.destroy');

        // Data Pengaduan
        Route::get('/data-pengaduan', [AdminPengaduanController::class, 'index'])->name('data-pengaduan.index');
        Route::get('/data-pengaduan/create', [AdminPengaduanController::class, 'create'])->name('data-pengaduan.create');
        Route::post('/data-pengaduan/store', [AdminPengaduanController::class, 'store'])->name('data-pengaduan.store');
        Route::get('/data-pengaduan/getMasalahPengaduanByKategori/{id}', [AdminPengaduanController::class, 'getMasalahPengaduanByKategori'])->name('data-pengaduan.getMasalahPengaduanByKategori');
        Route::get('/data-pengaduan/edit/{id}', [AdminPengaduanController::class, 'edit'])->name('data-pengaduan.edit');
        Route::get('/data-pengaduan/show/{id}', [AdminPengaduanController::class, 'show'])->name('data-pengaduan.show');
        Route::post('/data-pengaduan/update/{id}', [AdminPengaduanController::class, 'update'])->name('data-pengaduan.update');
        Route::post('/data-pengaduan/destroy/{id}', [AdminPengaduanController::class, 'destroy'])->name('data-pengaduan.destroy');
        Route::post('/data-pengaduan/sudahtervalidasi/{id}', [AdminPengaduanController::class, 'sudahtervalidasi'])->name('data-pengaduan.sudahtervalidasi');
        Route::post('/data-pengaduan/belumtervalidasi/{id}', [AdminPengaduanController::class, 'belumtervalidasi'])->name('data-pengaduan.belumtervalidasi');
        Route::post('/data-pengaduan/ditolak/{id}', [AdminPengaduanController::class, 'ditolak'])->name('data-pengaduan.ditolak');
        Route::post('/data-pengaduan/selesai/{id}', [AdminPengaduanController::class, 'selesai'])->name('data-pengaduan.selesai');

        // Warga
        Route::get('/data-warga', [AdminWargaController::class, 'index'])->name('data-warga.index');
        Route::get('/data-warga/create', [AdminWargaController::class, 'create'])->name('data-warga.create');
        Route::post('/data-warga/store', [AdminWargaController::class, 'store'])->name('data-warga.store');
        Route::get('/data-warga/edit/{id}', [AdminWargaController::class, 'edit'])->name('data-warga.edit');
        Route::post('/data-warga/update/{id}', [AdminWargaController::class, 'update'])->name('data-warga.update');
        Route::post('/data-warga/destroy/{id}', [AdminWargaController::class, 'destroy'])->name('data-warga.destroy');

        // Masalah Pengaduan
        Route::get('/data-masalahpengaduan', [AdminMasalahPengaduanController::class, 'index'])->name('data-masalahpengaduan.index');
        Route::get('/data-masalahpengaduan/create', [AdminMasalahPengaduanController::class, 'create'])->name('data-masalahpengaduan.create');
        Route::post('/data-masalahpengaduan/store', [AdminMasalahPengaduanController::class, 'store'])->name('data-masalahpengaduan.store');
        Route::get('/data-masalahpengaduan/edit/{id}', [AdminMasalahPengaduanController::class, 'edit'])->name('data-masalahpengaduan.edit');
        Route::post('/data-masalahpengaduan/update/{id}', [AdminMasalahPengaduanController::class, 'update'])->name('data-masalahpengaduan.update');
        Route::post('/data-masalahpengaduan/destroy/{id}', [AdminMasalahPengaduanController::class, 'destroy'])->name('data-masalahpengaduan.destroy');

        // Kategori Pengaduan
        Route::get('/data-kategoripengaduan', [AdminKategoriPengaduanController::class, 'index'])->name('data-kategoripengaduan.index');
        Route::get('/data-kategoripengaduan/create', [AdminKategoriPengaduanController::class, 'create'])->name('data-kategoripengaduan.create');
        Route::post('/data-kategoripengaduan/store', [AdminKategoriPengaduanController::class, 'store'])->name('data-kategoripengaduan.store');
        Route::get('/data-kategoripengaduan/edit/{id}', [AdminKategoriPengaduanController::class, 'edit'])->name('data-kategoripengaduan.edit');
        Route::post('/data-kategoripengaduan/update/{id}', [AdminKategoriPengaduanController::class, 'update'])->name('data-kategoripengaduan.update');
        Route::post('/data-kategoripengaduan/destroy/{id}', [AdminKategoriPengaduanController::class, 'destroy'])->name('data-kategoripengaduan.destroy');

        // Berita
        Route::get('/data-berita', [AdminBeritaController::class, 'index'])->name('data-berita.index');
        Route::get('/data-berita/create', [AdminBeritaController::class, 'create'])->name('data-berita.create');
        Route::post('/data-berita/store', [AdminBeritaController::class, 'store'])->name('data-berita.store');
        Route::get('/data-berita/edit/{id}', [AdminBeritaController::class, 'edit'])->name('data-berita.edit');
        Route::post('/data-berita/update/{id}', [AdminBeritaController::class, 'update'])->name('data-berita.update');
        Route::post('/data-berita/destroy/{id}', [AdminBeritaController::class, 'destroy'])->name('data-berita.destroy');

        // Kategori Berita
        Route::get('/data-kategoriberita', [AdminKategoriBeritaController::class, 'index'])->name('data-kategoriberita.index');
        Route::get('/data-kategoriberita/create', [AdminKategoriBeritaController::class, 'create'])->name('data-kategoriberita.create');
        Route::post('/data-kategoriberita/store', [AdminKategoriBeritaController::class, 'store'])->name('data-kategoriberita.store');
        Route::get('/data-kategoriberita/edit/{id}', [AdminKategoriBeritaController::class, 'edit'])->name('data-kategoriberita.edit');
        Route::post('/data-kategoriberita/update/{id}', [AdminKategoriBeritaController::class, 'update'])->name('data-kategoriberita.update');
        Route::post('/data-kategoriberita/destroy/{id}', [AdminKategoriBeritaController::class, 'destroy'])->name('data-kategoriberita.destroy');

        // Users
        Route::get('/data-user', [AdminUserController::class, 'index'])->name('data-user.index');
        Route::get('/data-user/create', [AdminUserController::class, 'create'])->name('data-user.create');
        Route::post('/data-user/store', [AdminUserController::class, 'store'])->name('data-user.store');
        Route::get('/data-user/edit/{id}', [AdminUserController::class, 'edit'])->name('data-user.edit');
        Route::post('/data-user/update/{id}', [AdminUserController::class, 'update'])->name('data-user.update');
        Route::post('/data-user/destroy/{id}', [AdminUserController::class, 'destroy'])->name('data-user.destroy');

        // Level
        Route::get('/data-level', [AdminLevelController::class, 'index'])->name('data-level.index');
        Route::get('/data-level/create', [AdminLevelController::class, 'create'])->name('data-level.create');
        Route::post('/data-level/store', [AdminLevelController::class, 'store'])->name('data-level.store');
        Route::get('/data-level/edit/{id}', [AdminLevelController::class, 'edit'])->name('data-level.edit');
        Route::post('/data-level/update/{id}', [AdminLevelController::class, 'update'])->name('data-level.update');
        Route::post('/data-level/destroy/{id}', [AdminLevelController::class, 'destroy'])->name('data-level.destroy');
    });
});
