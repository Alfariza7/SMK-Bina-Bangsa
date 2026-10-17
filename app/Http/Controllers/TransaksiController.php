<?php

namespace App\Http\Controllers;

use App\Models\TransaksiPaymentGateway;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Tampilkan data Transaksi Payment Gateway & Transaksi VA
     * (Dapat diakses Admin, Kepala Sekolah, dan Teller)
     */
    public function index(Request $request)
    {
        $query = TransaksiPaymentGateway::with(['siswa.kelas.jurusan', 'pembayaran.tagihanSpp']);

        // Filter Status Transaksi
        if ($request->filled('status') && in_array(strtoupper($request->status), ['PAID', 'FAILED'])) {
            $query->where('status_transaksi', strtoupper($request->status));
        }

        // Pencarian (Transaction ID, Nomor VA, Nama Siswa, NIS)
        if ($request->filled('search')) {
            $keyword = trim($request->search);
            $query->where(function ($q) use ($keyword) {
                $q->where('transaction_id', 'like', "%{$keyword}%")
                  ->orWhere('virtual_account', 'like', "%{$keyword}%")
                  ->orWhere('reference_number', 'like', "%{$keyword}%")
                  ->orWhereHas('siswa', function ($sq) use ($keyword) {
                      $sq->where('nama', 'like', "%{$keyword}%")
                         ->orWhere('nis', 'like', "%{$keyword}%");
                  });
            });
        }

        // Filter Tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_transaksi', $request->tanggal);
        }

        $transaksiList = $query->latest('id_transaksi')->get();

        // Ringkasan Metrik Transaksi
        $totalTransaksi = TransaksiPaymentGateway::count();
        $totalPaid = TransaksiPaymentGateway::where('status_transaksi', 'PAID')->count();
        $totalNominalPaid = TransaksiPaymentGateway::where('status_transaksi', 'PAID')->sum('nominal');
        $totalFailed = TransaksiPaymentGateway::where('status_transaksi', 'FAILED')->count();

        return view('transaksi.index', compact(
            'transaksiList',
            'totalTransaksi',
            'totalPaid',
            'totalNominalPaid',
            'totalFailed'
        ));
    }

    /**
     * Detail Transaksi Payment Gateway
     */
    public function show($id)
    {
        $transaksi = TransaksiPaymentGateway::with([
            'siswa.kelas.jurusan',
            'siswa.virtualAccount',
            'pembayaran.tagihanSpp'
        ])->findOrFail($id);

        return view('transaksi.show', compact('transaksi'));
    }
}
