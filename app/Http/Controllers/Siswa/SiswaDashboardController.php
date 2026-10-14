<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\TagihanSpp;
use Illuminate\Support\Facades\Auth;

class SiswaDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $siswa = Siswa::with(['kelas.jurusan', 'tahunAjaran', 'virtualAccount', 'tagihanSpp'])
            ->where('id_user', $user->id_user)
            ->first();

        if (!$siswa) {
            abort(404, 'Data siswa untuk akun ini belum dihubungkan.');
        }

        // Tagihan bulan ini / aktif
        $tagihanBulanIni = TagihanSpp::with('pembayaran.transaksiPaymentGateway')
            ->where('id_siswa', $siswa->id_siswa)
            ->where('bulan', 'September')
            ->where('tahun', 2026)
            ->first() ?? TagihanSpp::with('pembayaran.transaksiPaymentGateway')->where('id_siswa', $siswa->id_siswa)->latest()->first();

        // Daftar Tunggakan
        $daftarTunggakan = TagihanSpp::where('id_siswa', $siswa->id_siswa)
            ->where('status', 'TUNGGAKAN')
            ->get();
        $totalTunggakan = $daftarTunggakan->sum('nominal');

        // Riwayat Seluruh Tagihan / Pembayaran
        $riwayatTagihan = TagihanSpp::with('pembayaran.transaksiPaymentGateway')
            ->where('id_siswa', $siswa->id_siswa)
            ->orderBy('id_tagihan', 'desc')
            ->get();

        return view('siswa.dashboard', compact(
            'siswa',
            'tagihanBulanIni',
            'daftarTunggakan',
            'totalTunggakan',
            'riwayatTagihan'
        ));
    }
}
