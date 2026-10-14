<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    protected $primaryKey = 'id_siswa';

    protected $fillable = [
        'nis',
        'nisn',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'no_hp',
        'nama_orang_tua',
        'id_kelas',
        'id_tahun_ajaran',
        'id_user',
        'status',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'id_tahun_ajaran', 'id_tahun_ajaran');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function virtualAccount()
    {
        return $this->hasOne(VirtualAccount::class, 'id_siswa', 'id_siswa');
    }

    public function tagihanSpp()
    {
        return $this->hasMany(TagihanSpp::class, 'id_siswa', 'id_siswa');
    }

    public function transaksiPaymentGateway()
    {
        return $this->hasMany(TransaksiPaymentGateway::class, 'id_siswa', 'id_siswa');
    }
}
