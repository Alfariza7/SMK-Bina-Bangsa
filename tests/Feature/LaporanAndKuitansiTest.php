<?php

namespace Tests\Feature;

use App\Models\Siswa;
use App\Models\TagihanSpp;
use App\Models\TransaksiPaymentGateway;
use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;

class LaporanAndKuitansiTest extends TestCase
{
    protected $admin;
    protected $teller;
    protected $kepsek;
    protected $siswaUser;
    protected $siswaModel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::where('role', 'admin')->first();
        $this->teller = User::where('role', 'teller')->first();
        $this->kepsek = User::where('role', 'kepala_sekolah')->first();

        $this->siswaModel = Siswa::first();
        if ($this->siswaModel) {
            $this->siswaUser = User::find($this->siswaModel->id_user);
        }
    }

    public function test_guest_cannot_access_laporan()
    {
        $response = $this->get('/laporan');
        $response->assertRedirect('/login');
    }

    public function test_admin_can_access_laporan_index_and_cetak()
    {
        if ($this->admin) {
            $response = $this->actingAs($this->admin)->get('/laporan');
            $response->assertStatus(200);
            $response->assertSee('Laporan Rekapitulasi Pembayaran SPP');

            $printResponse = $this->actingAs($this->admin)->get('/laporan/cetak');
            $printResponse->assertStatus(200);
            $printResponse->assertSee('LAPORAN REKAPITULASI PEMBAYARAN SPP');
        }
    }

    public function test_teller_and_kepsek_can_access_laporan()
    {
        if ($this->teller) {
            $response = $this->actingAs($this->teller)->get('/laporan');
            $response->assertStatus(200);
        }

        if ($this->kepsek) {
            $response = $this->actingAs($this->kepsek)->get('/laporan');
            $response->assertStatus(200);
        }
    }

    public function test_siswa_cannot_access_laporan_page()
    {
        if ($this->siswaUser) {
            $response = $this->actingAs($this->siswaUser)->get('/laporan');
            $response->assertRedirect('/siswa/dashboard');
        }
    }

    public function test_authorized_users_can_view_kuitansi()
    {
        if ($this->siswaModel) {
            $trx = TransaksiPaymentGateway::firstOrCreate(
                ['transaction_id' => 'TRX-KWT-TEST-001'],
                [
                    'virtual_account' => '8800012345',
                    'id_siswa' => $this->siswaModel->id_siswa,
                    'tanggal_transaksi' => now()->toDateString(),
                    'waktu_transaksi' => '10:00:00',
                    'nominal' => 350000,
                    'status_transaksi' => 'PAID',
                    'payment_channel' => 'BCA_VA',
                    'reference_number' => 'REF-KWT-01',
                ]
            );

            // Siswa pemilik bisa melihat kuitansi
            if ($this->siswaUser) {
                $response = $this->actingAs($this->siswaUser)->get("/transaksi/{$trx->id_transaksi}/kuitansi");
                $response->assertStatus(200);
                $response->assertSee('KUITANSI PEMBAYARAN SPP');
                $response->assertSee('Tiga Ratus Lima Puluh Ribu');
            }

            // Admin bisa melihat kuitansi
            if ($this->admin) {
                $response = $this->actingAs($this->admin)->get("/transaksi/{$trx->id_transaksi}/kuitansi");
                $response->assertStatus(200);
            }
        }
    }
}
