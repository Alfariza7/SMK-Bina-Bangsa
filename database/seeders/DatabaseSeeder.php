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
use App\Models\TransaksiPaymentGateway;
use App\Models\Pembayaran;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
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

        // 2. Data 3 Jurusan: RPL, DKV, TKJ
        $rpl = Jurusan::create([
            'kode_jurusan' => 'RPL',
            'nama_jurusan' => 'Rekayasa Perangkat Lunak',
            'keterangan' => 'Pengembangan Perangkat Lunak, Game, dan Aplikasi Web',
        ]);

        $dkv = Jurusan::create([
            'kode_jurusan' => 'DKV',
            'nama_jurusan' => 'Desain Komunikasi Visual',
            'keterangan' => 'Desain Grafis, Animasi, Ilustrasi, dan Media Digital',
        ]);

        $tkj = Jurusan::create([
            'kode_jurusan' => 'TKJ',
            'nama_jurusan' => 'Teknik Komputer dan Jaringan',
            'keterangan' => 'Teknologi Jaringan Komputer, Server, dan Fiber Optic',
        ]);

        // 3. Data Tahun Ajaran
        $ta = TahunAjaran::create([
            'tahun_ajaran' => '2026/2027',
            'tanggal_mulai' => '2026-07-01',
            'tanggal_selesai' => '2027-06-30',
            'status' => 'aktif',
        ]);

        // 4. Data 9 Kelas: RPL (10, 11, 12), DKV (10, 11, 12), TKJ (10, 11, 12)
        $kelasList = [
            '10_RPL' => Kelas::create(['nama_kelas' => '10 RPL', 'tingkat' => '10', 'id_jurusan' => $rpl->id_jurusan, 'id_tahun_ajaran' => $ta->id_tahun_ajaran]),
            '10_DKV' => Kelas::create(['nama_kelas' => '10 DKV', 'tingkat' => '10', 'id_jurusan' => $dkv->id_jurusan, 'id_tahun_ajaran' => $ta->id_tahun_ajaran]),
            '10_TKJ' => Kelas::create(['nama_kelas' => '10 TKJ', 'tingkat' => '10', 'id_jurusan' => $tkj->id_jurusan, 'id_tahun_ajaran' => $ta->id_tahun_ajaran]),

            '11_RPL' => Kelas::create(['nama_kelas' => '11 RPL', 'tingkat' => '11', 'id_jurusan' => $rpl->id_jurusan, 'id_tahun_ajaran' => $ta->id_tahun_ajaran]),
            '11_DKV' => Kelas::create(['nama_kelas' => '11 DKV', 'tingkat' => '11', 'id_jurusan' => $dkv->id_jurusan, 'id_tahun_ajaran' => $ta->id_tahun_ajaran]),
            '11_TKJ' => Kelas::create(['nama_kelas' => '11 TKJ', 'tingkat' => '11', 'id_jurusan' => $tkj->id_jurusan, 'id_tahun_ajaran' => $ta->id_tahun_ajaran]),

            '12_RPL' => Kelas::create(['nama_kelas' => '12 RPL', 'tingkat' => '12', 'id_jurusan' => $rpl->id_jurusan, 'id_tahun_ajaran' => $ta->id_tahun_ajaran]),
            '12_DKV' => Kelas::create(['nama_kelas' => '12 DKV', 'tingkat' => '12', 'id_jurusan' => $dkv->id_jurusan, 'id_tahun_ajaran' => $ta->id_tahun_ajaran]),
            '12_TKJ' => Kelas::create(['nama_kelas' => '12 TKJ', 'tingkat' => '12', 'id_jurusan' => $tkj->id_jurusan, 'id_tahun_ajaran' => $ta->id_tahun_ajaran]),
        ];

        // 5. Data Tarif SPP
        $tarif = TarifSpp::create([
            'id_tahun_ajaran' => $ta->id_tahun_ajaran,
            'nominal' => 350000,
            'keterangan' => 'Tarif SPP Reguler TA 2026/2027',
            'status' => 'aktif',
        ]);

        // 6. Data 45 Siswa (5 Siswa per Kelas, 9 Kelas)
        // 10 RPL memuat: Indah, Joshua, Kimmy, Nadin, Nomi sesuai permintaan user
        $dataPerKelas = [
            '10_RPL' => [
                ['nama' => 'Indah Permatasari', 'nis' => '10101', 'nisn' => '0091010101', 'jk' => 'P'],
                ['nama' => 'Joshua Pratama',    'nis' => '10102', 'nisn' => '0091010102', 'jk' => 'L'],
                ['nama' => 'Kimmy Kurniawan',   'nis' => '10103', 'nisn' => '0091010103', 'jk' => 'L'],
                ['nama' => 'Nadin Safitri',     'nis' => '10104', 'nisn' => '0091010104', 'jk' => 'P'],
                ['nama' => 'Nomi Aurelia',      'nis' => '10105', 'nisn' => '0091010105', 'jk' => 'P'],
            ],
            '10_DKV' => [
                ['nama' => 'Aditya Nugraha',    'nis' => '10201', 'nisn' => '0091020101', 'jk' => 'L'],
                ['nama' => 'Bella Safira',       'nis' => '10202', 'nisn' => '0091020102', 'jk' => 'P'],
                ['nama' => 'Calvin Jonathan',    'nis' => '10203', 'nisn' => '0091020103', 'jk' => 'L'],
                ['nama' => 'Dinda Kirana',       'nis' => '10204', 'nisn' => '0091020104', 'jk' => 'P'],
                ['nama' => 'Eko Prasetyo',       'nis' => '10205', 'nisn' => '0091020105', 'jk' => 'L'],
            ],
            '10_TKJ' => [
                ['nama' => 'Fajar Ramadhan',     'nis' => '10301', 'nisn' => '0091030101', 'jk' => 'L'],
                ['nama' => 'Gita Gutawa',        'nis' => '10302', 'nisn' => '0091030102', 'jk' => 'P'],
                ['nama' => 'Hendra Setiawan',    'nis' => '10303', 'nisn' => '0091030103', 'jk' => 'L'],
                ['nama' => 'Intan Permata',      'nis' => '10304', 'nisn' => '0091030104', 'jk' => 'P'],
                ['nama' => 'Kevin Wijaya',       'nis' => '10305', 'nisn' => '0091030105', 'jk' => 'L'],
            ],
            '11_RPL' => [
                ['nama' => 'Ahmad Fauzan',       'nis' => '11101', 'nisn' => '0081110101', 'jk' => 'L'],
                ['nama' => 'Siti Aminah',        'nis' => '11102', 'nisn' => '0081110102', 'jk' => 'P'],
                ['nama' => 'Budi Santoso',       'nis' => '11103', 'nisn' => '0081110103', 'jk' => 'L'],
                ['nama' => 'Citra Lestari',      'nis' => '11104', 'nisn' => '0081110104', 'jk' => 'P'],
                ['nama' => 'Danu Wijaya',        'nis' => '11105', 'nisn' => '0081110105', 'jk' => 'L'],
            ],
            '11_DKV' => [
                ['nama' => 'Elena Maharani',     'nis' => '11201', 'nisn' => '0081120101', 'jk' => 'P'],
                ['nama' => 'Farhan Maulana',     'nis' => '11202', 'nisn' => '0081120102', 'jk' => 'L'],
                ['nama' => 'Gabriella Shani',    'nis' => '11203', 'nisn' => '0081120103', 'jk' => 'P'],
                ['nama' => 'Haris Sanjaya',      'nis' => '11204', 'nisn' => '0081120104', 'jk' => 'L'],
                ['nama' => 'Jessica Veranda',    'nis' => '11205', 'nisn' => '0081120105', 'jk' => 'P'],
            ],
            '11_TKJ' => [
                ['nama' => 'Kevin Sanjaya',      'nis' => '11301', 'nisn' => '0081130101', 'jk' => 'L'],
                ['nama' => 'Larasati Dewi',      'nis' => '11302', 'nisn' => '0081130102', 'jk' => 'P'],
                ['nama' => 'Muhammad Rizky',     'nis' => '11303', 'nisn' => '0081130103', 'jk' => 'L'],
                ['nama' => 'Nadia Putri',        'nis' => '11304', 'nisn' => '0081130104', 'jk' => 'P'],
                ['nama' => 'Oscar Saputra',      'nis' => '11305', 'nisn' => '0081130105', 'jk' => 'L'],
            ],
            '12_RPL' => [
                ['nama' => 'Putri Salma',        'nis' => '12101', 'nisn' => '0071210101', 'jk' => 'P'],
                ['nama' => 'Qori Hidayat',       'nis' => '12102', 'nisn' => '0071210102', 'jk' => 'L'],
                ['nama' => 'Raditya Pratama',    'nis' => '12103', 'nisn' => '0071210103', 'jk' => 'L'],
                ['nama' => 'Sabrina Angeline',   'nis' => '12104', 'nisn' => '0071210104', 'jk' => 'P'],
                ['nama' => 'Taufik Ismail',      'nis' => '12105', 'nisn' => '0071210105', 'jk' => 'L'],
            ],
            '12_DKV' => [
                ['nama' => 'Umar Faruq',         'nis' => '12201', 'nisn' => '0071220101', 'jk' => 'L'],
                ['nama' => 'Vania Aurellia',     'nis' => '12202', 'nisn' => '0071220102', 'jk' => 'P'],
                ['nama' => 'Wahyu Tri Atmojo',   'nis' => '12203', 'nisn' => '0071220103', 'jk' => 'L'],
                ['nama' => 'Xena Valerie',       'nis' => '12204', 'nisn' => '0071220104', 'jk' => 'P'],
                ['nama' => 'Yoga Pratama',       'nis' => '12205', 'nisn' => '0071220105', 'jk' => 'L'],
            ],
            '12_TKJ' => [
                ['nama' => 'Zaskia Sungkar',     'nis' => '12301', 'nisn' => '0071230101', 'jk' => 'P'],
                ['nama' => 'Arya Saloka',        'nis' => '12302', 'nisn' => '0071230102', 'jk' => 'L'],
                ['nama' => 'Bintang Emon',       'nis' => '12303', 'nisn' => '0071230103', 'jk' => 'L'],
                ['nama' => 'Chelsea Islan',      'nis' => '12304', 'nisn' => '0071230104', 'jk' => 'P'],
                ['nama' => 'Dimas Anggara',      'nis' => '12305', 'nisn' => '0071230105', 'jk' => 'L'],
            ],
        ];

        $trxCounter = 1;

        foreach ($dataPerKelas as $keyKelas => $muridList) {
            $kelasObj = $kelasList[$keyKelas];

            foreach ($muridList as $index => $m) {
                // Buat user akun login untuk siswa (username = NIS, password = siswa123)
                $userSiswa = User::create([
                    'nama' => $m['nama'],
                    'username' => $m['nis'],
                    'password' => Hash::make('siswa123'),
                    'role' => 'siswa',
                    'status' => 'aktif',
                ]);

                // Buat data Siswa
                $siswa = Siswa::create([
                    'nis' => $m['nis'],
                    'nisn' => $m['nisn'],
                    'nama' => $m['nama'],
                    'jenis_kelamin' => $m['jk'],
                    'tempat_lahir' => 'Sidoarjo',
                    'tanggal_lahir' => '2008-05-10',
                    'alamat' => 'Jl. Pendidikan No. ' . $m['nis'] . ', Sidoarjo',
                    'no_hp' => '0812' . rand(10000000, 99999999),
                    'nama_orang_tua' => 'Wali dari ' . $m['nama'],
                    'id_kelas' => $kelasObj->id_kelas,
                    'id_tahun_ajaran' => $ta->id_tahun_ajaran,
                    'id_user' => $userSiswa->id_user,
                    'status' => 'aktif',
                ]);

                // Buat Nomor Virtual Account (5 digit terakhir = NIS sesuai aturan LSP)
                $vaNumber = '88000' . $m['nis'];
                VirtualAccount::create([
                    'id_siswa' => $siswa->id_siswa,
                    'prefix' => '88000',
                    'nomor_va' => $vaNumber,
                    'status' => 'aktif',
                    'tanggal_dibuat' => now(),
                ]);

                // Logika Tagihan SPP:
                // Skenario:
                // 1. Indah (NIS 10101): Target demo pengujian LSP
                //    - Juli 2026: LUNAS
                //    - Agustus 2026: LUNAS
                //    - September 2026: BELUM BAYAR (Rp 350.000, jatuh tempo 30 Sept 2026)
                // 2. Siswa lainnya: kombinasi realistis LUNAS, BELUM BAYAR, dan TUNGGAKAN

                if ($m['nis'] === '10101') {
                    // Indah (Akun Demo Utama)
                    $this->createTagihanLunas($siswa, $tarif, $ta, 'Juli', 2026, '2026-07-31', '2026-07-20 09:30:00', $vaNumber, $trxCounter++);
                    $this->createTagihanLunas($siswa, $tarif, $ta, 'Agustus', 2026, '2026-08-31', '2026-08-25 14:15:00', $vaNumber, $trxCounter++);

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
                } elseif ($index === 1 || $index === 2) {
                    // Sebagian siswa tertib bayar (LUNAS Juli, Agustus, September)
                    $this->createTagihanLunas($siswa, $tarif, $ta, 'Juli', 2026, '2026-07-31', '2026-07-15 11:00:00', $vaNumber, $trxCounter++);
                    $this->createTagihanLunas($siswa, $tarif, $ta, 'Agustus', 2026, '2026-08-31', '2026-08-18 10:20:00', $vaNumber, $trxCounter++);
                    $this->createTagihanLunas($siswa, $tarif, $ta, 'September', 2026, '2026-09-30', '2026-09-28 13:45:00', $vaNumber, $trxCounter++);
                } elseif ($index === 3) {
                    // Menunggak September (Lewat 30 Sept 2026)
                    $this->createTagihanLunas($siswa, $tarif, $ta, 'Juli', 2026, '2026-07-31', '2026-07-22 08:30:00', $vaNumber, $trxCounter++);
                    $this->createTagihanLunas($siswa, $tarif, $ta, 'Agustus', 2026, '2026-08-31', '2026-08-29 16:00:00', $vaNumber, $trxCounter++);
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
                } else {
                    // Menunggak Agustus & September
                    $this->createTagihanLunas($siswa, $tarif, $ta, 'Juli', 2026, '2026-07-31', '2026-07-10 14:10:00', $vaNumber, $trxCounter++);
                    TagihanSpp::create([
                        'id_siswa' => $siswa->id_siswa,
                        'id_tarif' => $tarif->id_tarif,
                        'id_tahun_ajaran' => $ta->id_tahun_ajaran,
                        'bulan' => 'Agustus',
                        'tahun' => 2026,
                        'nominal' => 350000,
                        'tanggal_jatuh_tempo' => '2026-08-31',
                        'status' => 'TUNGGAKAN',
                    ]);
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

                // Tagihan bulan Oktober 2026 untuk seluruh siswa (status BELUM BAYAR)
                TagihanSpp::create([
                    'id_siswa' => $siswa->id_siswa,
                    'id_tarif' => $tarif->id_tarif,
                    'id_tahun_ajaran' => $ta->id_tahun_ajaran,
                    'bulan' => 'Oktober',
                    'tahun' => 2026,
                    'nominal' => 350000,
                    'tanggal_jatuh_tempo' => '2026-10-31',
                    'status' => 'BELUM BAYAR',
                ]);
            }
        }
    }

    /**
     * Helper untuk membuat tagihan LUNAS beserta relasi transaksi PG dan pembayaran
     */
    private function createTagihanLunas($siswa, $tarif, $ta, $bulan, $tahun, $tglJatuhTempo, $paidAt, $vaNumber, $trxCounter)
    {
        $tagihan = TagihanSpp::create([
            'id_siswa' => $siswa->id_siswa,
            'id_tarif' => $tarif->id_tarif,
            'id_tahun_ajaran' => $ta->id_tahun_ajaran,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'nominal' => 350000,
            'tanggal_jatuh_tempo' => $tglJatuhTempo,
            'status' => 'LUNAS',
        ]);

        $paidCarbon = Carbon::parse($paidAt);
        $trxId = 'TRX-' . $paidCarbon->format('Ymd') . '-' . str_pad($trxCounter, 4, '0', STR_PAD_LEFT);

        $channels = ['BCA_VA', 'MANDIRI_VA', 'BNI_VA', 'BRI_VA'];
        $channel = $channels[$trxCounter % count($channels)];

        $trx = TransaksiPaymentGateway::create([
            'transaction_id' => $trxId,
            'virtual_account' => $vaNumber,
            'id_siswa' => $siswa->id_siswa,
            'tanggal_transaksi' => $paidCarbon->toDateString(),
            'waktu_transaksi' => $paidCarbon->toTimeString(),
            'nominal' => 350000,
            'status_transaksi' => 'PAID',
            'payment_channel' => $channel,
            'reference_number' => 'REF-' . strtoupper(Str::random(10)),
            'raw_response' => [
                'transaction_id' => $trxId,
                'status' => 'PAID',
                'amount' => 350000,
                'virtual_account' => $vaNumber,
                'paid_at' => $paidAt
            ],
            'created_at' => $paidCarbon,
            'updated_at' => $paidCarbon,
        ]);

        Pembayaran::create([
            'id_transaksi' => $trx->id_transaksi,
            'id_tagihan' => $tagihan->id_tagihan,
            'tanggal_pembayaran' => $paidCarbon->toDateString(),
            'nominal_pembayaran' => 350000,
            'status' => 'LUNAS',
            'created_at' => $paidCarbon,
            'updated_at' => $paidCarbon,
        ]);
    }
}
