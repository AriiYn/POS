<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function detail()
    {
        // Ambil semua data dan urutkan berdasarkan created_at (descending)
        $details = DetailTransaksi::orderBy('created_at', 'desc')->get();  // Mengurutkan berdasarkan created_at
        $transactions = Transaksi::orderBy('created_at', 'desc')->get();  // Mengurutkan berdasarkan tanggal
    
        // Kirim kedua data ke view
        return view('detail', compact('details', 'transactions'));
    }    

    public function show($transaksi_id)
    {
        // Ambil data transaksi untuk menampilkan informasi header (opsional)
        $transaksi = Transaksi::findOrFail($transaksi_id);

        // Ambil semua detail transaksi yang terkait dengan transaksi_id tersebut
        $detailTransaksis = DetailTransaksi::where('transaksi_id', $transaksi_id)->get();

        return view('print', compact('transaksi', 'detailTransaksis'));
    }
}
