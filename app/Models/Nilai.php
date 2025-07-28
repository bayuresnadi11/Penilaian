<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'nilai';

    protected $fillable = [
        'id',
        'nip',
        'nis',
        'kode',
        'nilai',
        'predikat',
        'semester',
    ];

    // Relationship ke Guru
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'nip', 'nip');
    }

    // Relationship ke Murid
    public function murid()
    {
        return $this->belongsTo(Murid::class, 'nis', 'nis');
    }

    // Relationship ke Mata Pelajaran (nama asli)
    public function mapel()
    {
        return $this->belongsTo(Mata_Pelajaran::class, 'kode', 'kode');
    }

    // Alias untuk relationship mata pelajaran (untuk konsistensi dengan controller)
    public function mataPelajaran()
    {
        return $this->belongsTo(Mata_Pelajaran::class, 'kode', 'kode');
    }

    // Accessor untuk mendapatkan nama mata pelajaran
    public function getNamaMataPelajaranAttribute()
    {
        return $this->mataPelajaran ? $this->mataPelajaran->nama : null;
    }

    // Accessor untuk mendapatkan nama murid
    public function getNamaMuridAttribute()
    {
        return $this->murid ? $this->murid->nama : null;
    }

    // Accessor untuk mendapatkan nama guru
    public function getNamaGuruAttribute()
    {
        return $this->guru ? $this->guru->nama : null;
    }

    // Scope untuk filter berdasarkan semester
    public function scopeSemester($query, $semester)
    {
        return $query->where('semester', $semester);
    }

    // Scope untuk filter berdasarkan mata pelajaran
    public function scopeByMapel($query, $kode)
    {
        return $query->where('kode', $kode);
    }

    // Scope untuk filter berdasarkan guru
    public function scopeByGuru($query, $nip)
    {
        return $query->where('nip', $nip);
    }

    // Scope untuk filter berdasarkan murid
    public function scopeByMurid($query, $nis)
    {
        return $query->where('nis', $nis);
    }
}