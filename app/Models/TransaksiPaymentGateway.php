<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPaymentGateway extends Model
{
    use HasFactory;

    protected $table = 'transaksi_payment_gateway';
    protected $primaryKey = 'id_transaksi';

    protected $fillable = [
        'transaction_id',
        'virtual_account',
        'id_siswa',
        'tanggal_transaksi',
        'waktu_transaksi',
        'nominal',
        'status_transaksi',
        'payment_channel',
        'reference_number',
        'raw_response',
    ];

    protected $casts = [
        'raw_response' => 'array',
        'tanggal_transaksi' => 'date',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_transaksi', 'id_transaksi');
    }
}
