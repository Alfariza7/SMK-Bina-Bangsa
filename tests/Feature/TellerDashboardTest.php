<?php

namespace Tests\Feature;

use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\TagihanSpp;
use App\Models\TahunAjaran;
use App\Models\TarifSpp;
use App\Models\TransaksiPaymentGateway;
use App\Models\User;
use App\Models\VirtualAccount;
use Illuminate\Support\Str;
use Tests\TestCase;

class TellerDashboardTest extends TestCase
{
    protected $teller;
    protected $siswa;

    protected function setUp(): void
    {
        parent::setUp();

        $this->teller = User::firstOrCreate(
            ['username' => 'teller_test'],
            [
                'password' => bcrypt('password'),
                'nama' => 'Staf Teller Penguji',
                'role' => 'teller',
                'status' => 'aktif',
            ]
        );

        $this->siswa = Siswa::first();
    }

    public function test_guest_is_redirected_from_teller_dashboard()
    {
        $response = $this->get('/teller/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_teller_can_view_dashboard_successfully()
    {
        $response = $this->actingAs($this->teller)->get('/teller/dashboard');
        $response->assertStatus(200);
        $response->assertSeeText('Layanan & Informasi Siswa (Teller)');
    }

    public function test_teller_dashboard_renders_with_transactions_without_date_error()
    {
        if ($this->siswa) {
            $trx = TransaksiPaymentGateway::create([
                'transaction_id' => 'TRX-TEST-' . strtoupper(Str::random(6)),
                'virtual_account' => '8800099999',
                'id_siswa' => $this->siswa->id_siswa,
                'tanggal_transaksi' => now()->toDateString(),
                'waktu_transaksi' => '14:30:00',
                'nominal' => 350000,
                'status_transaksi' => 'PAID',
                'payment_channel' => 'VIRTUAL_ACCOUNT',
                'reference_number' => 'REF-' . strtoupper(Str::random(8)),
            ]);
        }

        $response = $this->actingAs($this->teller)->get('/teller/dashboard');
        $response->assertStatus(200);
        if (isset($trx)) {
            $response->assertSee($trx->transaction_id);
            $response->assertSee('14:30');
        }
    }
}
