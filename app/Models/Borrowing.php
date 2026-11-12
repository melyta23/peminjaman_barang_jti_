<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_transaksi',
        'user_id',
        'nama_peminjam',
        'nim_nip',
        'prodi',
        'no_hp',
        'email',
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_pengembalian_aktual',
        'keperluan',
        'status',
        'catatan_admin',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali' => 'date',
        'tanggal_pengembalian_aktual' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(BorrowingDetail::class);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'menunggu' => 'bg-warning text-dark',
            'disetujui' => 'bg-primary text-white',
            'ditolak' => 'bg-danger text-white',
            'selesai' => 'bg-success text-white',
            default => 'bg-secondary text-white',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'menunggu' => 'Menunggu Konfirmasi',
            'disetujui' => 'Disetujui / Sedang Dipinjam',
            'ditolak' => 'Ditolak',
            'selesai' => 'Sudah Dikembalikan',
            default => ucfirst($this->status),
        };
    }
}

