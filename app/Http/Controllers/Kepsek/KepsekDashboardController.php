<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\TagihanSpp;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class KepsekDashboardController extends Controller
{
    public function index()
    {
        $siswaAktif = Siswa::where('status', 'aktif')->count();
        $totalPenerimaan = Pembayaran::sum('nominal_pembayaran');
        $totalTunggakan = TagihanSpp::where('status', 'TUNGGAKAN')->sum('nominal');

        // Jumlah siswa lunas, belum bayar, menunggak (pada bulan berjalan atau secara umum)
        $jumlahSiswaMenunggak = TagihanSpp::where('status', 'TUNGGAKAN')->distinct('id_siswa')->count('id_siswa');
        $jumlahSiswaBelumBayar = TagihanSpp::where('status', 'BELUM BAYAR')->distinct('id_siswa')->count('id_siswa');
        $jumlahSiswaLunas = TagihanSpp::where('status', 'LUNAS')->distinct('id_siswa')->count('id_siswa');

        // Data Tren Penerimaan SPP Per Bulan (Dinamis)
        $trenPenerimaan = TagihanSpp::where('status', 'LUNAS')
            ->selectRaw('bulan, tahun, sum(nominal) as total_nominal, count(distinct id_siswa) as jumlah_siswa')
            ->groupBy('bulan', 'tahun')
            ->orderByRaw('MIN(id_tagihan) ASC')
            ->get();

        // Data Komparasi Siswa Menunggak Per Bulan (100% Sinkron dengan kartu metrik)
        $komparasiTunggakan = TagihanSpp::where('status', 'TUNGGAKAN')
            ->selectRaw('bulan, tahun, sum(nominal) as total_nominal, count(distinct id_siswa) as jumlah_siswa')
            ->groupBy('bulan', 'tahun')
            ->orderByRaw('MIN(id_tagihan) ASC')
            ->get();

        return view('kepsek.dashboard', compact(
            'siswaAktif',
            'totalPenerimaan',
            'totalTunggakan',
            'jumlahSiswaMenunggak',
            'jumlahSiswaBelumBayar',
            'jumlahSiswaLunas',
            'trenPenerimaan',
            'komparasiTunggakan'
        ));
    }
}
