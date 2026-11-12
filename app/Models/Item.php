<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'kode_barang',
        'nama_barang',
        'merk',
        'stok_total',
        'stok_tersedia',
        'kondisi',
        'lokasi_penyimpanan',
        'gambar',
        'deskripsi',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function borrowingDetails()
    {
        return $this->hasMany(BorrowingDetail::class);
    }

    public function getStatusLabelAttribute(): string
    {
        if ($this->stok_tersedia > 0) {
            return 'Tersedia (' . $this->stok_tersedia . ' unit)';
        }
        return 'Sedang Dipinjam / Habis';
    }

    public function getStatusBadgeAttribute(): string
    {
        if ($this->stok_tersedia > 0) {
            return 'bg-success';
        }
        return 'bg-danger';
    }
}

