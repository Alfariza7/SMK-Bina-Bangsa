<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\TagihanSpp;
use App\Models\TransaksiPaymentGateway;
use App\Models\VirtualAccount;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentGatewayController extends Controller
{
    /**
     * Halaman Simulator Payment Gateway & Webhook Tester
     */
    public function simulator(Request $request)
    {
        // Ambil daftar siswa beserta VA dan tagihan belum lunas untuk demo cepat
        $siswaList = Siswa::with(['kelas', 'virtualAccount', 'tagihanSpp' => function ($q) {
            $q->whereIn('status', ['BELUM BAYAR', 'TUNGGAKAN'])->orderBy('id_tagihan', 'asc');
        }])
        ->whereHas('virtualAccount')
        ->where('status', 'aktif')
        ->get();

        $selectedVa = $request->query('va');
        $preselectedStudent = null;
        if ($selectedVa) {
            $preselectedStudent = $siswaList->firstWhere('virtualAccount.nomor_va', $selectedVa);
        }

        // Histori transaksi simulator terbaru
        $riwayatTransaksi = TransaksiPaymentGateway::with(['siswa', 'pembayaran.tagihanSpp'])
            ->latest()
            ->take(10)
            ->get();

        return view('payment.simulator', compact('siswaList', 'selectedVa', 'preselectedStudent', 'riwayatTransaksi'));
    }

    /**
     * API Get Recent Transactions for Live Log Refresh
     */
    public function getTransactions()
    {
        $transactions = TransaksiPaymentGateway::with(['siswa', 'pembayaran.tagihanSpp'])
            ->latest('id_transaksi')
            ->take(15)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $transactions,
        ]);
    }

    /**
     * API Inquiry / Cek Virtual Account
     */
    public function inquiry(Request $request)
    {
        $request->validate([
            'virtual_account' => ['required'],
        ]);

        $vaNumber = trim($request->virtual_account);

        // Cari nomor VA
        $va = VirtualAccount::with(['siswa.kelas.jurusan'])->where('nomor_va', $vaNumber)->first();

        if (!$va) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor Virtual Account tidak terdaftar.',
            ], 404);
        }

        if ($va->status !== 'aktif') {
            return response()->json([
                'success' => false,
                'message' => 'Virtual Account ini sedang dinonaktifkan.',
            ], 400);
        }

        // Validasi 5 digit terakhir VA harus sama dengan NIS
        $expectedNis = substr($vaNumber, -5);
        if ($va->siswa->nis !== $expectedNis) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor VA tidak valid (5 digit terakhir harus sesuai dengan NIS siswa: ' . $va->siswa->nis . ').',
            ], 422);
        }

        // Cari tagihan yang belum lunas (BELUM BAYAR atau TUNGGAKAN)
        $tagihanList = TagihanSpp::where('id_siswa', $va->id_siswa)
            ->whereIn('status', ['BELUM BAYAR', 'TUNGGAKAN'])
            ->orderBy('id_tagihan', 'asc')
            ->get();

        if ($tagihanList->isEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'Siswa atas nama ' . $va->siswa->nama . ' tidak memiliki tagihan aktif (Seluruh tagihan sudah LUNAS).',
                'data' => [
                    'virtual_account' => $va->nomor_va,
                    'siswa' => [
                        'id_siswa' => $va->siswa->id_siswa,
                        'nama' => $va->siswa->nama,
                        'nis' => $va->siswa->nis,
                        'kelas' => $va->siswa->kelas->nama_kelas ?? '-',
                        'jurusan' => $va->siswa->kelas->jurusan->nama_jurusan ?? '-',
                    ],
                    'tagihan' => null,
                ]
            ], 200);
        }

        // Ambil tagihan prioritas terlama (misal tunggakan duluan atau bulan berjalan)
        $tagihanAktif = $tagihanList->first();

        return response()->json([
            'success' => true,
            'message' => 'Inquiry VA berhasil ditemukan.',
            'data' => [
                'virtual_account' => $va->nomor_va,
                'siswa' => [
                    'id_siswa' => $va->siswa->id_siswa,
                    'nis' => $va->siswa->nis,
                    'nama' => $va->siswa->nama,
                    'kelas' => $va->siswa->kelas->nama_kelas ?? '-',
                    'jurusan' => $va->siswa->kelas->jurusan->nama_jurusan ?? '-',
                ],
                'tagihan' => [
                    'id_tagihan' => $tagihanAktif->id_tagihan,
                    'bulan' => $tagihanAktif->bulan,
                    'tahun' => $tagihanAktif->tahun,
                    'nominal' => (float)$tagihanAktif->nominal,
                    'tanggal_jatuh_tempo' => $tagihanAktif->tanggal_jatuh_tempo,
                    'status' => $tagihanAktif->status,
                ],
                'daftar_tagihan_lain' => $tagihanList,
            ]
        ]);
    }

    /**
     * Reset Tagihan Demo untuk Siswa Ahmad Fauzan (NIS: 12345)
     */
    public function resetDemo()
    {
        $siswa = Siswa::where('nis', '12345')->first();
        if (!$siswa) {
            return response()->json(['success' => false, 'message' => 'Siswa Ahmad Fauzan tidak ditemukan.'], 404);
        }

        // Cari atau buat tagihan September 2026
        $tagihanSept = TagihanSpp::firstOrNew([
            'id_siswa' => $siswa->id_siswa,
            'bulan' => 'September',
            'tahun' => 2026,
        ]);

        $tagihanSept->nominal = 350000;
        $tagihanSept->tanggal_jatuh_tempo = '2026-09-30';
        $tagihanSept->status = 'BELUM BAYAR';
        $tagihanSept->save();

        // Hapus pembayaran terkait tagihan September 2026
        Pembayaran::where('id_tagihan', $tagihanSept->id_tagihan)->delete();

        // Hapus transaksi payment gateway dummy Ahmad Fauzan agar transaction_id bisa diuji ulang
        TransaksiPaymentGateway::where('id_siswa', $siswa->id_siswa)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tagihan demo Ahmad Fauzan (September 2026 - Rp 350.000) berhasil direset ke status BELUM BAYAR!',
            'data' => [
                'nis' => $siswa->nis,
                'nama' => $siswa->nama,
                'bulan' => 'September 2026',
                'nominal' => 350000,
                'status' => 'BELUM BAYAR',
                'virtual_account' => '8800012345',
            ]
        ]);
    }

    /**
     * Endpoint Callback / Webhook Payment Gateway (Poin G, H, I Dokumen Soal)
     */
    public function callback(Request $request)
    {
        // 1. Validasi struktur payload callback (Poin H & W)
        $request->validate([
            'virtual_account' => ['required'],
            'amount' => ['required', 'numeric', 'min:1'],
            'transaction_id' => ['required', 'string'],
            'status' => ['required', 'string'],
        ]);

        $transactionId = trim($request->transaction_id);
        $vaNumber = trim($request->virtual_account);
        $amount = (float)$request->amount;
        $statusPayment = strtoupper(trim($request->status));
        $paidAt = $request->input('paid_at', now()->toDateTimeString());

        // 2. Validasi Anti Duplikasi: Transaction ID harus unik (Poin W & Y)
        $existingTrx = TransaksiPaymentGateway::where('transaction_id', $transactionId)->first();
        if ($existingTrx) {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi ditolak: Transaction ID [' . $transactionId . '] sudah pernah diproses sebelumnya (Anti Duplikasi).',
            ], 409);
        }

        // 3. Cari Virtual Account di sistem
        $va = VirtualAccount::with('siswa')->where('nomor_va', $vaNumber)->first();
        if (!$va) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor Virtual Account [' . $vaNumber . '] tidak terdaftar di sistem sekolah.',
            ], 404);
        }

        // 4. Validasi 5 Digit Terakhir VA = NIS Siswa (Poin F, W, Y)
        $expectedNis = substr($vaNumber, -5);
        if ($va->siswa->nis !== $expectedNis) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi VA Gagal: 5 digit terakhir VA harus sama dengan NIS siswa (' . $va->siswa->nis . ').',
            ], 422);
        }

        // 5. Cari Tagihan yang sesuai (Bisa berdasarkan id_tagihan tertentu atau tagihan tertua yang belum lunas)
        $tagihanQuery = TagihanSpp::where('id_siswa', $va->id_siswa);
        
        if ($request->filled('id_tagihan')) {
            $tagihan = $tagihanQuery->where('id_tagihan', $request->id_tagihan)->first();
        } else {
            $tagihan = $tagihanQuery->whereIn('status', ['BELUM BAYAR', 'TUNGGAKAN'])->orderBy('id_tagihan', 'asc')->first();
        }

        if (!$tagihan) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ditemukan tagihan aktif atau tagihan siswa tersebut sudah berstatus LUNAS.',
            ], 400);
        }

        // 6. Cegah pembayaran pada tagihan yang sudah lunas (Poin W: Pembayaran yang sudah lunas tidak boleh diproses dua kali)
        if ($tagihan->status === 'LUNAS') {
            return response()->json([
                'success' => false,
                'message' => 'Tagihan bulan ' . $tagihan->bulan . ' ' . $tagihan->tahun . ' sudah LUNAS sebelumnya. Pembayaran ganda ditolak.',
            ], 422);
        }

        // 7. Validasi Nominal Pembayaran harus valid dan cocok (Poin W)
        if ((float)$tagihan->nominal !== $amount) {
            return response()->json([
                'success' => false,
                'message' => 'Nominal pembayaran (Rp ' . number_format($amount, 0, ',', '.') . ') tidak cocok dengan tagihan (Rp ' . number_format($tagihan->nominal, 0, ',', '.') . ').',
            ], 422);
        }

        // 8. Jika Status Transaksi Bukan PAID (misal: FAILED atau EXPIRED)
        if ($statusPayment !== 'PAID') {
            $failedTrx = TransaksiPaymentGateway::create([
                'transaction_id' => $transactionId,
                'virtual_account' => $vaNumber,
                'id_siswa' => $va->id_siswa,
                'tanggal_transaksi' => Carbon::parse($paidAt)->toDateString(),
                'waktu_transaksi' => Carbon::parse($paidAt)->toTimeString(),
                'nominal' => $amount,
                'status_transaksi' => $statusPayment,
                'payment_channel' => $request->input('payment_channel', 'VIRTUAL_ACCOUNT'),
                'reference_number' => $request->input('reference_number', 'REF-' . strtoupper(Str::random(10))),
                'raw_response' => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Transaksi tercatat dengan status: ' . $statusPayment . '. Tagihan tidak diubah.',
                'data' => $failedTrx
            ], 200);
        }

        // 9. Eksekusi Pembayaran Sukses (Atomic Transaction)
        $previousStatus = $tagihan->status;
        
        $result = DB::transaction(function () use ($request, $transactionId, $vaNumber, $va, $tagihan, $amount, $paidAt, $statusPayment) {
            // A. Simpan ke tabel transaksi_payment_gateway
            $trx = TransaksiPaymentGateway::create([
                'transaction_id' => $transactionId,
                'virtual_account' => $vaNumber,
                'id_siswa' => $va->id_siswa,
                'tanggal_transaksi' => Carbon::parse($paidAt)->toDateString(),
                'waktu_transaksi' => Carbon::parse($paidAt)->toTimeString(),
                'nominal' => $amount,
                'status_transaksi' => 'PAID',
                'payment_channel' => $request->input('payment_channel', 'VIRTUAL_ACCOUNT'),
                'reference_number' => $request->input('reference_number', 'REF-' . strtoupper(Str::random(10))),
                'raw_response' => $request->all(),
            ]);

            // B. Simpan ke tabel pembayaran
            $pembayaran = Pembayaran::create([
                'id_transaksi' => $trx->id_transaksi,
                'id_tagihan' => $tagihan->id_tagihan,
                'tanggal_pembayaran' => Carbon::parse($paidAt)->toDateString(),
                'nominal_pembayaran' => $amount,
                'status' => 'LUNAS',
            ]);

            // C. Update status tagihan_spp menjadi LUNAS
            $tagihan->update([
                'status' => 'LUNAS',
            ]);

            return [
                'transaksi' => $trx,
                'pembayaran' => $pembayaran,
            ];
        });

        // 10. Respon Sukses Callback
        return response()->json([
            'success' => true,
            'message' => 'Callback berhasil diproses! Tagihan ' . $tagihan->bulan . ' ' . $tagihan->tahun . ' resmi berstatus LUNAS.',
            'data' => [
                'transaction_id' => $transactionId,
                'virtual_account' => $vaNumber,
                'siswa' => [
                    'nis' => $va->siswa->nis,
                    'nama' => $va->siswa->nama,
                ],
                'tagihan' => [
                    'id_tagihan' => $tagihan->id_tagihan,
                    'bulan' => $tagihan->bulan . ' ' . $tagihan->tahun,
                    'nominal' => $amount,
                    'status_sebelumnya' => $previousStatus,
                    'status_sekarang' => 'LUNAS',
                ],
                'paid_at' => $paidAt,
                'payment_channel' => $request->input('payment_channel', 'VIRTUAL_ACCOUNT'),
            ]
        ], 200);
    }
}
