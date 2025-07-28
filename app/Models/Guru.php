<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    // Set primary key menjadi 'nip'
    protected $primaryKey = 'nip';

    // Nonaktifkan auto-increment karena 'nip' adalah primary key dan bukan auto-increment
    public $incrementing = false;

    // Tipe kunci primary key adalah string karena 'nip' adalah string
    protected $keyType = 'string';

    protected $table = 'guru';

    protected $fillable = [
        'nip',
        'nama',
        'email',
        'no_telp',
        'jenis_kelamin',
        'tgl_lahir',
        'username_user',
        'kode_mapel',
        'created_at',
        'updated_at',
    ];

    // Relasi ke Mata_Pelajaran
    public function mataPelajaran()
    {
        return $this->belongsTo(Mata_Pelajaran::class, 'kode_mapel', 'kode');
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'username_user', 'username');
    }

    // Relasi ke Nilai
    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'nip_guru', 'nip');
    }

    // Override getKey untuk mengembalikan kunci primary key
    public function getKey()
    {
        return $this->nip;
    }

    // Menggunakan nip untuk routing
    public function getRouteKeyName()
    {
        return 'nip';
    }
}
