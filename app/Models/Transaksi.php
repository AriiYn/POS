<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    // Jika nama tabel tidak mengikuti konvensi plural dari nama model, 
    // Anda bisa mendefinisikan nama tabel secara eksplisit.
    protected $table = 'transaksis';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = ['tanggal_bayar', 'total_harga', 'pay', 'return_amount'];

    /**
     * Relasi ke detail transaksi.
     * Satu transaksi dapat memiliki banyak detail transaksi.
     */
    public function details()
    {
        return $this->hasMany(DetailTransaksi::class, 'transaksi_id');
    }
}