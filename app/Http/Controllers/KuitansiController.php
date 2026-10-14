<?php

namespace App\Http\Controllers;

use App\Models\TransaksiPaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KuitansiController extends Controller
{
    /**
     * Tampilkan Kuitansi / Bukti Pembayaran Digital
     */
    public function show($id)
    {
        $transaksi = TransaksiPaymentGateway::with([
            'siswa.kelas.jurusan',
            'siswa.virtualAccount',
            'pembayaran.tagihanSpp.tahunAjaran'
        ])->findOrFail($id);

        // Jika user adalah siswa, pastikan hanya boleh mencetak kuitansi miliknya
        $user = Auth::user();
        if ($user->role === 'siswa') {
            if (!$user->siswa || $transaksi->id_siswa !== $user->siswa->id_siswa) {
                abort(403, 'Anda tidak berhak mengakses kuitansi ini.');
            }
        }

        $tagihan = $transaksi->pembayaran->tagihanSpp ?? null;
        $terbilang = $this->terbilang((int)$transaksi->nominal) . ' Rupiah';

        return view('laporan.kuitansi', compact('transaksi', 'tagihan', 'terbilang'));
    }

    /**
     * Konversi angka nominal ke kalimat terbilang bahasa Indonesia
     */
    private function terbilang($angka): string
    {
        $angka = abs((int)$angka);
        $baca = [
            '', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 
            'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'
        ];

        if ($angka < 12) {
            return $baca[$angka];
        } elseif ($angka < 20) {
            return $this->terbilang($angka - 10) . ' Belas';
        } elseif ($angka < 100) {
            $sisa = $angka % 10;
            return $this->terbilang((int)($angka / 10)) . ' Puluh' . ($sisa ? ' ' . $this->terbilang($sisa) : '');
        } elseif ($angka < 200) {
            $sisa = $angka - 100;
            return 'Seratus' . ($sisa ? ' ' . $this->terbilang($sisa) : '');
        } elseif ($angka < 1000) {
            $sisa = $angka % 100;
            return $this->terbilang((int)($angka / 100)) . ' Ratus' . ($sisa ? ' ' . $this->terbilang($sisa) : '');
        } elseif ($angka < 2000) {
            $sisa = $angka - 1000;
            return 'Seribu' . ($sisa ? ' ' . $this->terbilang($sisa) : '');
        } elseif ($angka < 1000000) {
            $sisa = $angka % 1000;
            return $this->terbilang((int)($angka / 1000)) . ' Ribu' . ($sisa ? ' ' . $this->terbilang($sisa) : '');
        } elseif ($angka < 1000000000) {
            $sisa = $angka % 1000000;
            return $this->terbilang((int)($angka / 1000000)) . ' Juta' . ($sisa ? ' ' . $this->terbilang($sisa) : '');
        } elseif ($angka < 1000000000000) {
            $sisa = fmod($angka, 1000000000);
            return $this->terbilang((int)($angka / 1000000000)) . ' Miliar' . ($sisa ? ' ' . $this->terbilang($sisa) : '');
        }

        return (string)$angka;
    }
}
