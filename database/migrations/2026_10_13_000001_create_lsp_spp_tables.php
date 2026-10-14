<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 2. JURUSAN
        Schema::create('jurusan', function (Blueprint $table) {
            $table->id('id_jurusan');
            $table->string('kode_jurusan', 20)->unique();
            $table->string('nama_jurusan', 100);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        // 3. TAHUN AJARAN
        Schema::create('tahun_ajaran', function (Blueprint $table) {
            $table->id('id_tahun_ajaran');
            $table->string('tahun_ajaran', 20); // Contoh: 2026/2027
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });

        // 4. KELAS
        Schema::create('kelas', function (Blueprint $table) {
            $table->id('id_kelas');
            $table->string('nama_kelas', 50); // Contoh: XI RPL 1
            $table->string('tingkat', 10); // Contoh: 10, 11, 12 atau X, XI, XII
            $table->unsignedBigInteger('id_jurusan');
            $table->unsignedBigInteger('id_tahun_ajaran');
            $table->timestamps();

            $table->foreign('id_jurusan')->references('id_jurusan')->on('jurusan')->onDelete('cascade');
            $table->foreign('id_tahun_ajaran')->references('id_tahun_ajaran')->on('tahun_ajaran')->onDelete('cascade');
        });

        // 5. TARIF SPP
        Schema::create('tarif_spp', function (Blueprint $table) {
            $table->id('id_tarif');
            $table->unsignedBigInteger('id_tahun_ajaran');
            $table->decimal('nominal', 12, 2);
            $table->text('keterangan')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();

            $table->foreign('id_tahun_ajaran')->references('id_tahun_ajaran')->on('tahun_ajaran')->onDelete('cascade');
        });

        // 6. SISWA
        Schema::create('siswa', function (Blueprint $table) {
            $table->id('id_siswa');
            $table->string('nis', 20)->unique();
            $table->string('nisn', 20)->unique();
            $table->string('nama', 100);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->string('nama_orang_tua', 100)->nullable();
            $table->unsignedBigInteger('id_kelas');
            $table->unsignedBigInteger('id_tahun_ajaran');
            $table->unsignedBigInteger('id_user')->nullable()->unique();
            $table->enum('status', ['aktif', 'lulus', 'pindah', 'keluar'])->default('aktif');
            $table->timestamps();

            $table->foreign('id_kelas')->references('id_kelas')->on('kelas')->onDelete('cascade');
            $table->foreign('id_tahun_ajaran')->references('id_tahun_ajaran')->on('tahun_ajaran')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('set null');
        });

        // 7. VIRTUAL ACCOUNT
        Schema::create('virtual_account', function (Blueprint $table) {
            $table->id('id_va');
            $table->unsignedBigInteger('id_siswa')->unique();
            $table->string('nomor_va', 30)->unique();
            $table->string('prefix', 15)->default('88000');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamp('tanggal_dibuat')->useCurrent();
            $table->timestamps();

            $table->foreign('id_siswa')->references('id_siswa')->on('siswa')->onDelete('cascade');
        });

        // 8. TAGIHAN SPP
        Schema::create('tagihan_spp', function (Blueprint $table) {
            $table->id('id_tagihan');
            $table->unsignedBigInteger('id_siswa');
            $table->unsignedBigInteger('id_tarif');
            $table->unsignedBigInteger('id_tahun_ajaran');
            $table->string('bulan', 20); // Contoh: September atau integer bulan
            $table->year('tahun'); // Contoh: 2026
            $table->decimal('nominal', 12, 2);
            $table->date('tanggal_jatuh_tempo');
            $table->enum('status', ['BELUM BAYAR', 'LUNAS', 'TUNGGAKAN'])->default('BELUM BAYAR');
            $table->timestamps();

            $table->foreign('id_siswa')->references('id_siswa')->on('siswa')->onDelete('cascade');
            $table->foreign('id_tarif')->references('id_tarif')->on('tarif_spp')->onDelete('cascade');
            $table->foreign('id_tahun_ajaran')->references('id_tahun_ajaran')->on('tahun_ajaran')->onDelete('cascade');
        });

        // 9. TRANSAKSI PAYMENT GATEWAY
        Schema::create('transaksi_payment_gateway', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->string('transaction_id', 50)->unique();
            $table->string('virtual_account', 30)->index();
            $table->unsignedBigInteger('id_siswa');
            $table->date('tanggal_transaksi');
            $table->time('waktu_transaksi');
            $table->decimal('nominal', 12, 2);
            $table->string('status_transaksi', 30); // PAID, PENDING, FAILED
            $table->string('payment_channel', 50)->default('VIRTUAL_ACCOUNT');
            $table->string('reference_number', 100)->nullable();
            $table->json('raw_response')->nullable();
            $table->timestamps();

            $table->foreign('id_siswa')->references('id_siswa')->on('siswa')->onDelete('cascade');
        });

        // 10. PEMBAYARAN
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->unsignedBigInteger('id_transaksi')->unique();
            $table->unsignedBigInteger('id_tagihan');
            $table->date('tanggal_pembayaran');
            $table->decimal('nominal_pembayaran', 12, 2);
            $table->string('status', 30)->default('LUNAS');
            $table->timestamps();

            $table->foreign('id_transaksi')->references('id_transaksi')->on('transaksi_payment_gateway')->onDelete('cascade');
            $table->foreign('id_tagihan')->references('id_tagihan')->on('tagihan_spp')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
        Schema::dropIfExists('transaksi_payment_gateway');
        Schema::dropIfExists('tagihan_spp');
        Schema::dropIfExists('virtual_account');
        Schema::dropIfExists('siswa');
        Schema::dropIfExists('tarif_spp');
        Schema::dropIfExists('kelas');
        Schema::dropIfExists('tahun_ajaran');
        Schema::dropIfExists('jurusan');
    }
};
