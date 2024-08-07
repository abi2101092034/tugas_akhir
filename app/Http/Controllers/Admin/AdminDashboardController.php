<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $users = Auth::user();

        if ($users->level_id == '1') {
            $belumvalidasi = Pengaduan::where('statuspengaduan', 'Belum Tervalidasi')->count();
            $sudahvalidasi = Pengaduan::where('statuspengaduan', 'Sudah Tervalidasi')->count();
            $selesaivalidasi = Pengaduan::where('statuspengaduan', 'Selesai')->count();
            $ditolakvalidasi = Pengaduan::where('statuspengaduan', 'Ditolak')->count();

            // Menghitung jumlah pengaduan per bulan
            $countsPerMonth = Pengaduan::select(
                DB::raw('MONTH(tgl_pengaduan) as month'),
                DB::raw('YEAR(tgl_pengaduan) as year'),
                DB::raw('COUNT(*) as count')
            )
                ->groupBy('year', 'month')
                ->orderBy('year', 'asc')
                ->orderBy('month', 'asc')
                ->get();

            // Format data untuk chart atau tampilan
            $dataPerMonth = [];
            foreach ($countsPerMonth as $count) {
                $monthYear = sprintf('%d-%02d', $count->year, $count->month);
                $dataPerMonth[$monthYear] = $count->count;
            }

            return view('admin.dashboard.index', [
                'sudahvalidasi' => $sudahvalidasi,
                'belumvalidasi' => $belumvalidasi,
                'selesaivalidasi' => $selesaivalidasi,
                'ditolakvalidasi' => $ditolakvalidasi,
                'dataPerMonth' => $dataPerMonth,
            ]);
        } elseif ($users->level_id == '2') {
            return view('warga.dashboard.index');
        }
    }
}
