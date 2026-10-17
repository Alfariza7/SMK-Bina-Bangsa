<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\TagihanSpp;
use Illuminate\Http\Request;

class TagihanController extends Controller
{
    /**
     * Tampilkan data Tagihan Siswa, Status Tagihan, dan Tunggakan
     * (Dapat diakses Admin, Kepala Sekolah, dan Teller)
     */
    public function index(Request $request)
    {
        $kelasList = Kelas::orderBy('nama_kelas')->get();

        $query = TagihanSpp::with([
            'siswa.kelas.jurusan',
            'siswa.virtualAccount',
            'pembayaran.transaksiPaymentGateway'
        ]);

        // Filter Status
        if ($request->filled('status') && in_array($request->status, ['LUNAS', 'BELUM BAYAR', 'TUNGGAKAN'])) {
            $query->where('status', $request->status);
        }

        // Filter Kelas
        if ($request->filled('id_kelas')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('id_kelas', $request->id_kelas);
            });
        }

        // Filter Bulan
        if ($request->filled('bulan')) {
            $query->where('bulan', $request->bulan);
        }

        // Pencarian Nama / NIS / VA
        if ($request->filled('search')) {
            $keyword = trim($request->search);
            $query->whereHas('siswa', function ($q) use ($keyword) {
                $q->where('nama', 'like', "%{$keyword}%")
                  ->orWhere('nis', 'like', "%{$keyword}%")
                  ->orWhereHas('virtualAccount', function ($vaQ) use ($keyword) {
                      $vaQ->where('nomor_va', 'like', "%{$keyword}%");
                  });
            });
        }

        $tagihanList = $query->orderBy('tahun', 'desc')
                             ->orderBy('bulan', 'desc')
                             ->orderBy('id_tagihan', 'desc')
                             ->get();

        // Ringkasan Metrik
        $totalTagihan = TagihanSpp::count();
        $totalLunas = TagihanSpp::where('status', 'LUNAS')->count();
        $nominalLunas = TagihanSpp::where('status', 'LUNAS')->sum('nominal');
        $totalBelumBayar = TagihanSpp::where('status', 'BELUM BAYAR')->count();
        $nominalBelumBayar = TagihanSpp::where('status', 'BELUM BAYAR')->sum('nominal');
        $totalTunggakan = TagihanSpp::where('status', 'TUNGGAKAN')->count();
        $nominalTunggakan = TagihanSpp::where('status', 'TUNGGAKAN')->sum('nominal');

        return view('tagihan.index', compact(
            'tagihanList',
            'kelasList',
            'totalTagihan',
            'totalLunas',
            'nominalLunas',
            'totalBelumBayar',
            'nominalBelumBayar',
            'totalTunggakan',
            'nominalTunggakan'
        ));
    }
}
