<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    // Jika nama tabel tidak mengikuti konvensi plural dari nama model,
    // Anda dapat mendefinisikannya secara eksplisit.
    protected $table = 'detail_transaksi';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = ['transaksi_id', 'produk_id', 'total_harga', 'quantity', 'subtotal'];

    /**
     * Relasi ke model Transaksi.
     */
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }

    /**
     * (Opsional) Relasi ke model Produk.
     * Pastikan model Produk sudah ada dan sesuai kebutuhan.
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
