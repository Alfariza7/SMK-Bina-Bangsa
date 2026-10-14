<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagihanSpp extends Model
{
    use HasFactory;

    protected $table = 'tagihan_spp';
    protected $primaryKey = 'id_tagihan';

    protected $fillable = [
        'id_siswa',
        'id_tarif',
        'id_tahun_ajaran',
        'bulan',
        'tahun',
        'nominal',
        'tanggal_jatuh_tempo',
        'status', // 'BELUM BAYAR', 'LUNAS', 'TUNGGAKAN'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    public function tarifSpp()
    {
        return $this->belongsTo(TarifSpp::class, 'id_tarif', 'id_tarif');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'id_tahun_ajaran', 'id_tahun_ajaran');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_tagihan', 'id_tagihan');
    }
}
