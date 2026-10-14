<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'id_user';

    protected $fillable = [
        'nama',
        'username',
        'password',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function siswa()
    {
        return $this->hasOne(Siswa::class, 'id_user', 'id_user');
    }

    /**
     * Inisial nama cerdas (mengabaikan gelar di depan seperti Drs., Ir., Prof., H., Hj., dsb.)
     */
    public function getInitialAttribute(): string
    {
        $nama = trim($this->nama ?? $this->username ?? 'U');
        // Bersihkan gelar umum di depan
        $prefixPattern = '/^(dr\.|drs\.|dra\.|drg\.|ir\.|prof\.|kh\.|h\.|hj\.|ustadz\.|ust\.|st\.|spd\.|mpd\.)\s+/i';
        while (preg_match($prefixPattern, $nama)) {
            $nama = preg_replace($prefixPattern, '', $nama);
        }
        $nama = trim($nama);
        return strtoupper(substr($nama, 0, 1)) ?: 'U';
    }
}
