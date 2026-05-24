<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Anggota extends Model
{
    use HasFactory;

    protected $table = 'anggota';
    protected $fillable = [
        'kode_anggota',
        'nama',
        'email',
        'telepon',
        'alamat',
        'tanggal_lahir',
        'jenis_kelamin',
        'pekerjaan',
        'tanggal_daftar',
        'status'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_daftar' => 'date',
    ];

    public function getUmurAttribute(): int
    {
        return Carbon::parse($this->tanggal_lahir)->age;
    }

    public function getLamaAnggotaAttribute(): int
    {
        return Carbon::parse($this->tanggal_daftar)->diffInYears(Carbon::now());
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'Aktif');
    }

    public function scopeJenisKelamin($query, $jenis)
    {
        return $query->where('jenis_kelamin', $jenis);
    }

    public function getStatusBadgeAttribute(): string
    {
        if ($this->status === 'Aktif') {
            return '<span class="badge bg-success">Aktif</span>';
        }

        return '<span class="badge bg-secondary">Nonaktif</span>';
    }

    public function getKategoriUsiaAttribute(): string
    {
        if ($this->umur < 20) {
            return 'Remaja';
        } elseif ($this->umur <= 50) {
            return 'Dewasa';
        }

        return 'Senior';
    }

    public function scopeTerdaftarBulanIni($query)
    {
        return $query->whereMonth('tanggal_daftar', now()->month)
            ->whereYear('tanggal_daftar', now()->year);
    }
    
}
