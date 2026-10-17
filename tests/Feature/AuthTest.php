<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * Uji tampilkan halaman login
     */
    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('SMK BINA BANGSA');
    }

    /**
     * Uji validasi field kosong (Poin W & X)
     */
    public function test_empty_fields_fail_validation(): void
    {
        $response = $this->post('/login', [
            'username' => '',
            'password' => '',
        ]);

        $response->assertSessionHasErrors(['username', 'password']);
    }

    /**
     * Uji username salah (Poin X)
     */
    public function test_invalid_username_fails(): void
    {
        $response = $this->post('/login', [
            'username' => 'wrong_username',
            'password' => 'secret123',
        ]);

        $response->assertSessionHasErrors('username');
    }

    /**
     * Uji password salah (Poin X)
     */
    public function test_invalid_password_fails(): void
    {
        $response = $this->post('/login', [
            'username' => 'admin',
            'password' => 'wrong_password',
        ]);

        $response->assertSessionHasErrors('password');
    }

    /**
     * Uji login admin valid (Poin X)
     */
    public function test_admin_can_login_and_redirect_to_dashboard(): void
    {
        $response = $this->post('/login', [
            'username' => 'admin',
            'password' => 'admin123',
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticated();
    }

    /**
     * Uji login siswa valid (Poin X)
     */
    public function test_siswa_can_login_and_redirect_to_dashboard(): void
    {
        $response = $this->post('/login', [
            'username' => '10101',
            'password' => 'siswa123',
        ]);

        $response->assertRedirect('/siswa/dashboard');
        $this->assertAuthenticated();
    }

    /**
     * Uji logout fungsional
     */
    public function test_user_can_logout(): void
    {
        $user = User::where('username', 'admin')->first();
        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }
}
