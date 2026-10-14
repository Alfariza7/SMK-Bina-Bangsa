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

    public function getWaktuFormattedAttribute(): string
    {
        if ($this->tanggal_transaksi) {
            $date = $this->tanggal_transaksi instanceof \Carbon\Carbon
                ? $this->tanggal_transaksi->format('d/m/Y')
                : \Carbon\Carbon::parse($this->tanggal_transaksi)->format('d/m/Y');
            $time = $this->waktu_transaksi ? ' ' . substr($this->waktu_transaksi, 0, 5) : '';
            return $date . $time;
        }

        return $this->created_at ? $this->created_at->format('d/m/Y H:i') : '-';
    }
}
