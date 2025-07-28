<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mata_Pelajaran extends Model
{
    use HasFactory;

    // Set primary key menjadi 'kode'
    protected $primaryKey = 'kode';

    // Nonaktifkan auto-increment karena 'kode' adalah primary key dan bukan auto-increment
    public $incrementing = false;

    // Tipe kunci primary key adalah string karena 'kode' adalah string
    protected $keyType = 'string';

    protected $table = 'mata_pelajaran';

    protected $fillable = [
        'kode',
        'mata_pelajaran',
    ];

    public $timestamps = true;

    // Relasi ke Guru
    public function guru()
    {
        return $this->hasMany(Guru::class, 'kode_mapel', 'kode');
    }

    // Relasi ke Nilai
    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'kode_mapel', 'kode');
    }
}
