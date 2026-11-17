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
        'jam_mulai',
        'jam_selesai',
        'keperluan',
        'lokasi_penggunaan',
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

    public function getRentangWaktuAttribute(): string
    {
        $mulai = '07.00';
        if (!empty($this->jam_mulai)) {
            try {
                $mulai = \Carbon\Carbon::parse($this->jam_mulai)->format('H.i');
            } catch (\Throwable $e) {
                $mulai = (string) $this->jam_mulai;
            }
        }

        if (empty($this->jam_selesai) || strtolower(trim((string) $this->jam_selesai)) === 'selesai') {
            return "{$mulai} WIB – Selesai";
        }

        try {
            $selesai = \Carbon\Carbon::parse($this->jam_selesai)->format('H.i');
            return "{$mulai} WIB – {$selesai} WIB";
        } catch (\Throwable $e) {
            return "{$mulai} WIB – " . ucfirst($this->jam_selesai);
        }
    }
}

