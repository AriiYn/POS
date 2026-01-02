<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = ['nama_produk', 'kategori', 'stok', 'harga', 'diskon', 'total_harga'];

    // Menghitung total harga secara otomatis
    public static function boot()
    {
        parent::boot();
        static::saving(function ($produk) {
            $produk->total_harga = $produk->harga - ($produk->harga * $produk->diskon / 100);
        });
    }
}