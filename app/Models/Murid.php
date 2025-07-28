<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Murid extends Model
{
    use HasFactory;

    // Nonaktifkan auto-increment karena kita tidak menggunakan id lagi sebagai primary key
    public $incrementing = false;

    // Set primary key menjadi 'nis'
    protected $primaryKey = 'nis';

    // Tipe kunci primary key adalah string karena 'nis' adalah string
    protected $keyType = 'string';

    protected $table = 'murid';

    protected $fillable = [
        'nis',
        'nama',
        'kelas',
        'telepon',
        'jenis_kelamin',
        'tanggal_lahir',
        'username_user',
        'created_at',
        'updated_at',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'username_user', 'username');
    }

    // Relasi ke Nilai
    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'nis', 'nis'); // Perbarui relasi ini jika diperlukan
    }

    // Override getKey untuk mengembalikan kunci primary key
    public function getKey()
    {
        return $this->nis;
    }
}
