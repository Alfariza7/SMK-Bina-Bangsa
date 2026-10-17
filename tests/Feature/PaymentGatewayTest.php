<?php

namespace Tests\Feature;

use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\TagihanSpp;
use App\Models\TahunAjaran;
use App\Models\TarifSpp;
use App\Models\TransaksiPaymentGateway;
use App\Models\User;
use App\Models\VirtualAccount;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class PaymentGatewayTest extends TestCase
{
    protected $siswa;
    protected $va;
    protected $tagihan;

    protected function setUp(): void
    {
        parent::setUp();

        // Cari atau buat data pengujian
        $this->siswa = Siswa::where('nis', '12345')->first();
        if (!$this->siswa) {
            $user = User::create([
                'username' => '12345',
                'password' => bcrypt('siswa123'),
                'nama' => 'Ahmad Fauzan',
                'role' => 'siswa',
                'status' => 'aktif',
            ]);

            $ta = TahunAjaran::firstOrCreate(['tahun' => '2026/2027'], ['status' => 'aktif']);
            $jurusan = Jurusan::firstOrCreate(['kode_jurusan' => 'RPL'], ['nama_jurusan' => 'Rekayasa Perangkat Lunak']);
            $kelas = Kelas::firstOrCreate(['nama_kelas' => 'XII RPL 1'], ['id_jurusan' => $jurusan->id_jurusan, 'tingkat' => 'XII']);
            $tarif = TarifSpp::firstOrCreate(['id_tahun' => $ta->id_tahun, 'tingkat' => 'XII'], ['nominal' => 350000]);

            $this->siswa = Siswa::create([
                'id_user' => $user->id_user,
                'nis' => '12345',
                'nama' => 'Ahmad Fauzan',
                'id_kelas' => $kelas->id_kelas,
                'id_tarif' => $tarif->id_tarif,
                'alamat' => 'Sidoarjo',
                'telepon' => '081234567890',
                'status' => 'aktif',
            ]);
        }

        $this->va = VirtualAccount::firstOrCreate(
            ['id_siswa' => $this->siswa->id_siswa],
            [
                'nomor_va' => '8800012345',
                'bank' => 'BCA',
                'status' => 'aktif',
            ]
        );

        $idTarif = TarifSpp::first()?->id_tarif ?? 1;
        $idTahun = TahunAjaran::first()?->id_tahun_ajaran ?? 1;

        $this->tagihan = TagihanSpp::firstOrCreate(
            [
                'id_siswa' => $this->siswa->id_siswa,
                'bulan' => 'September',
                'tahun' => 2026,
            ],
            [
                'id_tarif' => $idTarif,
                'id_tahun_ajaran' => $idTahun,
                'nominal' => 350000,
                'tanggal_jatuh_tempo' => '2026-09-30',
                'status' => 'BELUM BAYAR',
            ]
        );
    }

    /**
     * Test Halaman Simulator Dapat Diakses
     */
    public function test_simulator_page_can_be_accessed(): void
    {
        $response = $this->get(route('payment.simulator'));
        $response->assertStatus(200);
        $response->assertSee('Simulator Payment Gateway');
    }

    /**
     * Test API Inquiry dengan VA yang Valid
     */
    public function test_inquiry_with_valid_va_returns_bill_data(): void
    {
        $response = $this->postJson(route('payment.inquiry'), [
            'virtual_account' => '8800012345',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => [
                'virtual_account' => '8800012345',
                'siswa' => [
                    'nis' => '12345',
                    'nama' => $this->siswa->nama,
                ],
            ],
        ]);
    }

    /**
     * Test API Inquiry dengan VA yang Tidak Terdaftar
     */
    public function test_inquiry_with_invalid_va_returns_404(): void
    {
        $response = $this->postJson(route('payment.inquiry'), [
            'virtual_account' => '9999999999',
        ]);

        $response->assertStatus(404);
        $response->assertJson([
            'success' => false,
        ]);
    }

    /**
     * Test Callback Sukses Merubah Status Tagihan Menjadi LUNAS (Poin G, H, I Dokumen Soal)
     */
    public function test_callback_success_updates_bill_to_lunas(): void
    {
        // Pastikan status sebelum bayar adalah BELUM BAYAR
        $this->tagihan->update(['status' => 'BELUM BAYAR']);

        $uniqueTrxId = 'TRX-TEST-' . Str::random(10);

        $response = $this->postJson(route('payment.callback'), [
            'virtual_account' => '8800012345',
            'amount' => 350000,
            'transaction_id' => $uniqueTrxId,
            'status' => 'PAID',
            'payment_channel' => 'BCA_VA',
            'id_tagihan' => $this->tagihan->id_tagihan,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => [
                'transaction_id' => $uniqueTrxId,
                'tagihan' => [
                    'status_sekarang' => 'LUNAS',
                ],
            ],
        ]);

        // Verifikasi database: tagihan berubah LUNAS
        $this->assertDatabaseHas('tagihan_spp', [
            'id_tagihan' => $this->tagihan->id_tagihan,
            'status' => 'LUNAS',
        ]);

        // Verifikasi database: tercatat di transaksi_payment_gateway
        $this->assertDatabaseHas('transaksi_payment_gateway', [
            'transaction_id' => $uniqueTrxId,
            'status_transaksi' => 'PAID',
        ]);

        // Verifikasi database: tercatat di pembayaran
        $this->assertDatabaseHas('pembayaran', [
            'id_tagihan' => $this->tagihan->id_tagihan,
            'nominal_pembayaran' => 350000,
            'status' => 'LUNAS',
        ]);
    }

    /**
     * Test Anti-Duplikasi: Callback dengan Transaction ID yang Sama Ditolak (HTTP 409)
     */
    public function test_callback_duplicate_transaction_id_is_rejected(): void
    {
        $duplicateTrxId = 'TRX-DUP-' . Str::random(8);

        // Buat transaksi pertama
        TransaksiPaymentGateway::create([
            'transaction_id' => $duplicateTrxId,
            'virtual_account' => '8800012345',
            'id_siswa' => $this->siswa->id_siswa,
            'tanggal_transaksi' => now()->toDateString(),
            'waktu_transaksi' => now()->toTimeString(),
            'nominal' => 350000,
            'status_transaksi' => 'PAID',
            'payment_channel' => 'BCA_VA',
        ]);

        // Callback kedua dengan ID yang sama
        $response = $this->postJson(route('payment.callback'), [
            'virtual_account' => '8800012345',
            'amount' => 350000,
            'transaction_id' => $duplicateTrxId,
            'status' => 'PAID',
        ]);

        $response->assertStatus(409);
        $response->assertJson([
            'success' => false,
        ]);
    }

    /**
     * Test Validasi Nominal: Callback dengan Nominal Salah Ditolak (HTTP 422)
     */
    public function test_callback_wrong_amount_is_rejected(): void
    {
        $this->tagihan->update(['status' => 'BELUM BAYAR']);

        $response = $this->postJson(route('payment.callback'), [
            'virtual_account' => '8800012345',
            'amount' => 100000, // Nominal salah (seharusnya 350000)
            'transaction_id' => 'TRX-WRONG-AMT-' . Str::random(8),
            'status' => 'PAID',
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'success' => false,
        ]);
    }

    /**
     * Test Callback dengan Status FAILED Tidak Merubah Tagihan Menjadi LUNAS
     */
    public function test_callback_failed_status_does_not_mark_bill_as_lunas(): void
    {
        $this->tagihan->update(['status' => 'BELUM BAYAR']);

        $trxId = 'TRX-FAILED-' . Str::random(8);

        $response = $this->postJson(route('payment.callback'), [
            'virtual_account' => '8800012345',
            'amount' => 350000,
            'transaction_id' => $trxId,
            'status' => 'FAILED',
            'id_tagihan' => $this->tagihan->id_tagihan,
        ]);

        $response->assertStatus(200);
        
        // Status tagihan tetap BELUM BAYAR
        $this->assertDatabaseHas('tagihan_spp', [
            'id_tagihan' => $this->tagihan->id_tagihan,
            'status' => 'BELUM BAYAR',
        ]);

        // Namun transaksi gagal tetap dicatat di riwayat log
        $this->assertDatabaseHas('transaksi_payment_gateway', [
            'transaction_id' => $trxId,
            'status_transaksi' => 'FAILED',
        ]);
    }

    /**
     * Test Fitur Reset Demo Siswa Ahmad Fauzan (September 2026 BELUM BAYAR)
     */
    public function test_reset_demo_restores_ahmad_fauzan_bill_to_belum_bayar(): void
    {
        $response = $this->postJson(route('payment.reset_demo'));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => [
                'nis' => '12345',
                'status' => 'BELUM BAYAR',
                'nominal' => 350000,
            ]
        ]);

        $this->assertDatabaseHas('tagihan_spp', [
            'id_siswa' => $this->siswa->id_siswa,
            'bulan' => 'September',
            'tahun' => 2026,
            'status' => 'BELUM BAYAR',
        ]);
    }
}
