<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';

    protected $fillable = [
        'id_transaksi',
        'id_tagihan',
        'tanggal_pembayaran',
        'nominal_pembayaran',
        'status',
    ];

    protected $casts = [
        'tanggal_pembayaran' => 'date',
    ];

    public function transaksiPaymentGateway()
    {
        return $this->belongsTo(TransaksiPaymentGateway::class, 'id_transaksi', 'id_transaksi');
    }

    public function tagihanSpp()
    {
        return $this->belongsTo(TagihanSpp::class, 'id_tagihan', 'id_tagihan');
    }
}
