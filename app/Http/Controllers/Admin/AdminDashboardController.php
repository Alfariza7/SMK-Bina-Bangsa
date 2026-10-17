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
        $totalSiswaMenunggak = TagihanSpp::where('status', 'TUNGGAKAN')->distinct('id_siswa')->count('id_siswa');
        $totalTransaksi = TransaksiPaymentGateway::count();
        $transaksiHariIni = TransaksiPaymentGateway::whereDate('tanggal_transaksi', Carbon::today())->count();
        $transaksiTerbaru = TransaksiPaymentGateway::with('siswa')->latest()->take(5)->get();

        // Data Grafik Penerimaan SPP Per Bulan (Dinamis dari database)
        $penerimaanPerBulan = TagihanSpp::where('status', 'LUNAS')
            ->selectRaw('bulan, tahun, sum(nominal) as total_nominal, count(distinct id_siswa) as jumlah_siswa')
            ->groupBy('bulan', 'tahun')
            ->orderByRaw('MIN(id_tagihan) ASC')
            ->get();

        // Data Grafik Tunggakan Per Bulan (100% sinkron dengan kartu Total Tunggakan)
        $tunggakanPerBulan = TagihanSpp::where('status', 'TUNGGAKAN')
            ->selectRaw('bulan, tahun, sum(nominal) as total_nominal, count(distinct id_siswa) as jumlah_siswa')
            ->groupBy('bulan', 'tahun')
            ->orderByRaw('MIN(id_tagihan) ASC')
            ->get();

        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalTagihan',
            'totalPembayaran',
            'totalTunggakan',
            'totalSiswaMenunggak',
            'totalTransaksi',
            'transaksiHariIni',
            'transaksiTerbaru',
            'penerimaanPerBulan',
            'tunggakanPerBulan'
        ));
    }
}
