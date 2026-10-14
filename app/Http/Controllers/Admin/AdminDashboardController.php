<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\TagihanSpp;
use App\Models\Pembayaran;
use App\Models\TransaksiPaymentGateway;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalSiswa = Siswa::where('status', 'aktif')->count();
        $totalTagihan = TagihanSpp::count();
        $totalPembayaran = Pembayaran::sum('nominal_pembayaran');
        $totalTunggakan = TagihanSpp::where('status', 'TUNGGAKAN')->sum('nominal');
        $transaksiHariIni = TransaksiPaymentGateway::whereDate('created_at', Carbon::today())->count();
        $transaksiTerbaru = TransaksiPaymentGateway::with('siswa')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalTagihan',
            'totalPembayaran',
            'totalTunggakan',
            'transaksiHariIni',
            'transaksiTerbaru'
        ));
    }
}
