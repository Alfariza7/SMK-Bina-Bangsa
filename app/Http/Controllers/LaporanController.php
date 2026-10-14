<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\TagihanSpp;
use App\Models\TransaksiPaymentGateway;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Tampilkan halaman rekap laporan dengan opsi filter
     */
    public function index(Request $request)
    {
        $kelasList = Kelas::with('jurusan')->orderBy('nama_kelas')->get();

        $query = TagihanSpp::with([
            'siswa.kelas.jurusan',
            'siswa.virtualAccount',
            'pembayaran.transaksiPaymentGateway',
            'tarifSpp',
            'tahunAjaran'
        ]);

        // Filter Kelas
        if ($request->filled('id_kelas')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('id_kelas', $request->id_kelas);
            });
        }

        // Filter Status Tagihan
        if ($request->filled('status') && in_array($request->status, ['LUNAS', 'BELUM BAYAR', 'TUNGGAKAN'])) {
            $query->where('status', $request->status);
        }

        // Filter Rentang Tanggal Jatuh Tempo atau Tanggal Pembayaran
        if ($request->filled('tanggal_mulai')) {
            $tglMulai = Carbon::parse($request->tanggal_mulai)->startOfDay();
            $query->where('tanggal_jatuh_tempo', '>=', $tglMulai);
        }

        if ($request->filled('tanggal_selesai')) {
            $tglSelesai = Carbon::parse($request->tanggal_selesai)->endOfDay();
            $query->where('tanggal_jatuh_tempo', '<=', $tglSelesai);
        }

        $tagihanList = $query->orderBy('tahun', 'desc')
                             ->orderBy('bulan', 'desc')
                             ->orderBy('id_tagihan', 'desc')
                             ->get();

        // Hitung Ringkasan Metrik Laporan
        $totalTagihan = $tagihanList->count();
        $totalNominal = $tagihanList->sum('nominal');

        $lunasItems = $tagihanList->where('status', 'LUNAS');
        $totalLunas = $lunasItems->count();
        $nominalLunas = $lunasItems->sum('nominal');

        $tunggakanItems = $tagihanList->whereIn('status', ['BELUM BAYAR', 'TUNGGAKAN']);
        $totalTunggakan = $tunggakanItems->count();
        $nominalTunggakan = $tunggakanItems->sum('nominal');

        return view('laporan.index', compact(
            'kelasList',
            'tagihanList',
            'totalTagihan',
            'totalNominal',
            'totalLunas',
            'nominalLunas',
            'totalTunggakan',
            'nominalTunggakan'
        ));
    }

    /**
     * Tampilan dokumen cetak resmi (Print Preview)
     */
    public function cetak(Request $request)
    {
        $query = TagihanSpp::with([
            'siswa.kelas.jurusan',
            'siswa.virtualAccount',
            'pembayaran.transaksiPaymentGateway',
            'tarifSpp',
            'tahunAjaran'
        ]);

        $filterDeskripsi = [];

        // Filter Kelas
        if ($request->filled('id_kelas')) {
            $kelas = Kelas::find($request->id_kelas);
            if ($kelas) {
                $filterDeskripsi[] = "Kelas: {$kelas->nama_kelas}";
            }
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('id_kelas', $request->id_kelas);
            });
        } else {
            $filterDeskripsi[] = "Semua Kelas";
        }

        // Filter Status
        if ($request->filled('status') && in_array($request->status, ['LUNAS', 'BELUM BAYAR', 'TUNGGAKAN'])) {
            $filterDeskripsi[] = "Status: {$request->status}";
            $query->where('status', $request->status);
        } else {
            $filterDeskripsi[] = "Semua Status";
        }

        // Filter Tanggal
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $filterDeskripsi[] = "Periode: {$request->tanggal_mulai} s/d {$request->tanggal_selesai}";
            $query->whereBetween('tanggal_jatuh_tempo', [
                Carbon::parse($request->tanggal_mulai)->startOfDay(),
                Carbon::parse($request->tanggal_selesai)->endOfDay()
            ]);
        }

        $tagihanList = $query->orderBy('tahun', 'desc')
                             ->orderBy('bulan', 'desc')
                             ->get();

        $totalNominal = $tagihanList->sum('nominal');
        $nominalLunas = $tagihanList->where('status', 'LUNAS')->sum('nominal');
        $nominalTunggakan = $tagihanList->whereIn('status', ['BELUM BAYAR', 'TUNGGAKAN'])->sum('nominal');

        return view('laporan.cetak', compact(
            'tagihanList',
            'filterDeskripsi',
            'totalNominal',
            'nominalLunas',
            'nominalTunggakan'
        ));
    }
}
