<?php

namespace App\Http\Controllers\Teller;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\TransaksiPaymentGateway;
use App\Models\Siswa;
use App\Models\VirtualAccount;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TellerDashboardController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();
        $transaksiHariIni = TransaksiPaymentGateway::whereDate('created_at', $today)->count();
        $nominalHariIni = TransaksiPaymentGateway::whereDate('created_at', $today)->sum('nominal');
        $transaksiTerbaru = TransaksiPaymentGateway::with('siswa')->latest()->take(5)->get();

        $searchResult = null;
        $keyword = $request->query('keyword');

        if ($keyword) {
            // Pencarian berdasarkan NIS, Nama, atau Nomor VA
            $searchResult = Siswa::with(['kelas.jurusan', 'virtualAccount', 'tagihanSpp'])
                ->where('nis', $keyword)
                ->orWhere('nisn', $keyword)
                ->orWhere('nama', 'like', "%{$keyword}%")
                ->orWhereHas('virtualAccount', function ($q) use ($keyword) {
                    $q->where('nomor_va', $keyword);
                })
                ->first();
        }

        return view('teller.dashboard', compact(
            'transaksiHariIni',
            'nominalHariIni',
            'transaksiTerbaru',
            'searchResult',
            'keyword'
        ));
    }
}
