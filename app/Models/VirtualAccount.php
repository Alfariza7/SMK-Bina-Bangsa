<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VirtualAccount extends Model
{
    use HasFactory;

    protected $table = 'virtual_account';
    protected $primaryKey = 'id_va';

    protected $fillable = [
        'id_siswa',
        'nomor_va',
        'prefix',
        'status',
        'tanggal_dibuat',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }
}
