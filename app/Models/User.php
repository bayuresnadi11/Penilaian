<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users'; // Nama tabel (default Laravel)

    // Nonaktifkan auto-increment karena kita menggunakan username sebagai primary key
    public $incrementing = false;

    // Tipe kunci primary key adalah string karena username adalah string
    protected $keyType = 'string';

    // Menjadikan username sebagai primary key
    protected $primaryKey = 'username';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'username',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    // Relasi ke Guru (jika user adalah guru)
    public function guru()
    {
        return $this->hasOne(Guru::class, 'id_user');
    }

    // Relasi ke Murid (jika user adalah murid)
    public function murid()
    {
        return $this->hasOne(Murid::class, 'id_user'); // Sesuaikan dengan relasi yang tepat
    }

    public function isGuru()
    {
        return $this->role === 'guru';
    }

    public function isMurid()
    {
        return $this->role === 'murid';
    }
}
