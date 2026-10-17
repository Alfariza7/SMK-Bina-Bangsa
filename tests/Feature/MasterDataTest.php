<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class MasterDataTest extends TestCase
{
    protected function getAdmin()
    {
        return User::where('role', 'admin')->first();
    }

    protected function getKepsek()
    {
        return User::where('role', 'kepala_sekolah')->first();
    }

    protected function getTeller()
    {
        return User::where('role', 'teller')->first();
    }

    public function test_admin_can_access_master_jurusan(): void
    {
        $admin = $this->getAdmin();
        $response = $this->actingAs($admin)->get('/admin/master/jurusan');

        $response->assertStatus(200);
        $response->assertSee('RPL');
        $response->assertSee('DKV');
        $response->assertSee('TKJ');
    }

    public function test_admin_can_access_master_tahun_ajaran(): void
    {
        $admin = $this->getAdmin();
        $response = $this->actingAs($admin)->get('/admin/master/tahun-ajaran');

        $response->assertStatus(200);
        $response->assertSee('2026/2027');
    }

    public function test_admin_can_access_master_kelas(): void
    {
        $admin = $this->getAdmin();
        $response = $this->actingAs($admin)->get('/admin/master/kelas');

        $response->assertStatus(200);
        $response->assertSee('10 RPL');
    }

    public function test_admin_can_access_master_tarif_spp(): void
    {
        $admin = $this->getAdmin();
        $response = $this->actingAs($admin)->get('/admin/master/tarif-spp');

        $response->assertStatus(200);
        $response->assertSee('Tarif SPP');
    }

    public function test_admin_can_access_master_va(): void
    {
        $admin = $this->getAdmin();
        $response = $this->actingAs($admin)->get('/admin/master/virtual-account');

        $response->assertStatus(200);
        $response->assertSee('Virtual Account');
    }

    public function test_admin_can_access_master_users(): void
    {
        $admin = $this->getAdmin();
        $response = $this->actingAs($admin)->get('/admin/master/users');

        $response->assertStatus(200);
        $response->assertSee('Data Pengguna');
    }

    public function test_admin_and_kepsek_and_teller_can_access_transaksi(): void
    {
        $admin = $this->getAdmin();
        $response = $this->actingAs($admin)->get('/transaksi');
        $response->assertStatus(200);

        $kepsek = $this->getKepsek();
        $responseKepsek = $this->actingAs($kepsek)->get('/transaksi');
        $responseKepsek->assertStatus(200);

        $teller = $this->getTeller();
        $responseTeller = $this->actingAs($teller)->get('/transaksi');
        $responseTeller->assertStatus(200);
    }

    public function test_admin_and_kepsek_and_teller_can_access_tagihan(): void
    {
        $admin = $this->getAdmin();
        $response = $this->actingAs($admin)->get('/tagihan');
        $response->assertStatus(200);

        $kepsek = $this->getKepsek();
        $responseKepsek = $this->actingAs($kepsek)->get('/tagihan');
        $responseKepsek->assertStatus(200);

        $teller = $this->getTeller();
        $responseTeller = $this->actingAs($teller)->get('/tagihan');
        $responseTeller->assertStatus(200);
    }

    public function test_admin_and_kepsek_and_teller_can_access_master_siswa(): void
    {
        $admin = $this->getAdmin();
        $response = $this->actingAs($admin)->get('/master/siswa');
        $response->assertStatus(200);

        $kepsek = $this->getKepsek();
        $responseKepsek = $this->actingAs($kepsek)->get('/master/siswa');
        $responseKepsek->assertStatus(200);

        $teller = $this->getTeller();
        $responseTeller = $this->actingAs($teller)->get('/master/siswa');
        $responseTeller->assertStatus(200);
    }
}
