<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Jurusan;
use App\Models\TahunAjaran;
use App\Models\Kelas;
use App\Models\TarifSpp;
use App\Models\Siswa;
use App\Models\VirtualAccount;
use App\Models\TagihanSpp;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Pegawai (Admin, Kepala Sekolah, Teller)
        User::create([
            'nama' => 'Administrator',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'status' => 'aktif',
        ]);

        User::create([
            'nama' => 'Drs. H. Mulyadi, M.Pd.',
            'username' => 'kepsek',
            'password' => Hash::make('kepsek123'),
            'role' => 'kepala_sekolah',
            'status' => 'aktif',
        ]);

        User::create([
            'nama' => 'Siti Nurhaliza',
            'username' => 'teller',
            'password' => Hash::make('teller123'),
            'role' => 'teller',
            'status' => 'aktif',
        ]);

        // 2. Data Jurusan
        $rpl = Jurusan::create([
            'kode_jurusan' => 'RPL',
            'nama_jurusan' => 'Rekayasa Perangkat Lunak',
            'keterangan' => 'Pengembangan Software dan Web',
        ]);

        $tkj = Jurusan::create([
            'kode_jurusan' => 'TKJ',
            'nama_jurusan' => 'Teknik Komputer dan Jaringan',
            'keterangan' => 'Infrastruktur Jaringan dan Server',
        ]);

        // 3. Data Tahun Ajaran
        $ta = TahunAjaran::create([
            'tahun_ajaran' => '2026/2027',
            'tanggal_mulai' => '2026-07-01',
            'tanggal_selesai' => '2027-06-30',
            'status' => 'aktif',
        ]);

        // 4. Data Kelas
        $kelasRpl1 = Kelas::create([
            'nama_kelas' => 'XI RPL 1',
            'tingkat' => '11',
            'id_jurusan' => $rpl->id_jurusan,
            'id_tahun_ajaran' => $ta->id_tahun_ajaran,
        ]);

        // 5. Data Tarif SPP
        $tarif = TarifSpp::create([
            'id_tahun_ajaran' => $ta->id_tahun_ajaran,
            'nominal' => 350000,
            'keterangan' => 'SPP Bulanan TA 2026/2027 Kelas XI',
            'status' => 'aktif',
        ]);

        // 6. Data Siswa sesuai lembar soal contoh (Ahmad Fauzan, Siti Aminah, Budi Santoso, Citra Lestari)
        $siswaData = [
            [
                'nis' => '12345',
                'nisn' => '0061234501',
                'nama' => 'Ahmad Fauzan',
                'jk' => 'L',
                'username' => '12345',
            ],
            [
                'nis' => '12346',
                'nisn' => '0061234502',
                'nama' => 'Siti Aminah',
                'jk' => 'P',
                'username' => '12346',
            ],
            [
                'nis' => '12347',
                'nisn' => '0061234503',
                'nama' => 'Budi Santoso',
                'jk' => 'L',
                'username' => '12347',
            ],
            [
                'nis' => '12348',
                'nisn' => '0061234504',
                'nama' => 'Citra Lestari',
                'jk' => 'P',
                'username' => '12348',
            ],
        ];

        foreach ($siswaData as $data) {
            // User login siswa
            $userSiswa = User::create([
                'nama' => $data['nama'],
                'username' => $data['username'],
                'password' => Hash::make('siswa123'),
                'role' => 'siswa',
                'status' => 'aktif',
            ]);

            // Data Siswa
            $siswa = Siswa::create([
                'nis' => $data['nis'],
                'nisn' => $data['nisn'],
                'nama' => $data['nama'],
                'jenis_kelamin' => $data['jk'],
                'tempat_lahir' => 'Sidoarjo',
                'tanggal_lahir' => '2008-05-10',
                'alamat' => 'Jl. Pendidikan Bangsa No. ' . $data['nis'],
                'no_hp' => '08123456789',
                'nama_orang_tua' => 'Wali Siswa ' . $data['nama'],
                'id_kelas' => $kelasRpl1->id_kelas,
                'id_tahun_ajaran' => $ta->id_tahun_ajaran,
                'id_user' => $userSiswa->id_user,
                'status' => 'aktif',
            ]);

            // Nomor VA: 5 digit terakhir = NIS (Prefix 88000)
            VirtualAccount::create([
                'id_siswa' => $siswa->id_siswa,
                'prefix' => '88000',
                'nomor_va' => '88000' . $data['nis'],
                'status' => 'aktif',
                'tanggal_dibuat' => now(),
            ]);

            // Buat contoh tagihan sesuai lembar soal LSP:
            // TA 2026/2027: Juli 2026, Agustus 2026, September 2026
            // Jatuh tempo tiap akhir bulan. Lewat tanggal 1 bulan berikutnya otomatis TUNGGAKAN.
            if ($data['nis'] === '12345') {
                // Ahmad Fauzan (Target Demo Pengujian LSP)
                TagihanSpp::create([
                    'id_siswa' => $siswa->id_siswa,
                    'id_tarif' => $tarif->id_tarif,
                    'id_tahun_ajaran' => $ta->id_tahun_ajaran,
                    'bulan' => 'Juli',
                    'tahun' => 2026,
                    'nominal' => 350000,
                    'tanggal_jatuh_tempo' => '2026-07-31',
                    'status' => 'LUNAS',
                ]);

                TagihanSpp::create([
                    'id_siswa' => $siswa->id_siswa,
                    'id_tarif' => $tarif->id_tarif,
                    'id_tahun_ajaran' => $ta->id_tahun_ajaran,
                    'bulan' => 'Agustus',
                    'tahun' => 2026,
                    'nominal' => 350000,
                    'tanggal_jatuh_tempo' => '2026-08-31',
                    'status' => 'LUNAS',
                ]);

                // Tagihan aktif untuk demonstrasi wajib LSP: September 2026 BELUM BAYAR
                TagihanSpp::create([
                    'id_siswa' => $siswa->id_siswa,
                    'id_tarif' => $tarif->id_tarif,
                    'id_tahun_ajaran' => $ta->id_tahun_ajaran,
                    'bulan' => 'September',
                    'tahun' => 2026,
                    'nominal' => 350000,
                    'tanggal_jatuh_tempo' => '2026-09-30',
                    'status' => 'BELUM BAYAR',
                ]);
            } elseif ($data['nis'] === '12346') {
                // Siti Aminah: Tertib bayar (LUNAS)
                TagihanSpp::create([
                    'id_siswa' => $siswa->id_siswa,
                    'id_tarif' => $tarif->id_tarif,
                    'id_tahun_ajaran' => $ta->id_tahun_ajaran,
                    'bulan' => 'September',
                    'tahun' => 2026,
                    'nominal' => 350000,
                    'tanggal_jatuh_tempo' => '2026-09-30',
                    'status' => 'LUNAS',
                ]);
            } else {
                // Budi Santoso & Citra Lestari: Menunggak September 2026 (lewat 30 September 2026)
                TagihanSpp::create([
                    'id_siswa' => $siswa->id_siswa,
                    'id_tarif' => $tarif->id_tarif,
                    'id_tahun_ajaran' => $ta->id_tahun_ajaran,
                    'bulan' => 'September',
                    'tahun' => 2026,
                    'nominal' => 350000,
                    'tanggal_jatuh_tempo' => '2026-09-30',
                    'status' => 'TUNGGAKAN',
                ]);
            }
        }
    }
}
