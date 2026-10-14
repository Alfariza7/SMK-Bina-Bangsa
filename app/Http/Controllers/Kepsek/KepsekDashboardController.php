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

        return view('kepsek.dashboard', compact(
            'siswaAktif',
            'totalPenerimaan',
            'totalTunggakan',
            'jumlahSiswaMenunggak',
            'jumlahSiswaBelumBayar',
            'jumlahSiswaLunas'
        ));
    }
}
