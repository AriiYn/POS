<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function transaksi()
    {
        // Ambil produk yang memiliki stok lebih dari 0
        $menu = Produk::where('stok', '>', 0)->get();
        return view('transaksi', compact('menu'));
    }    

    // Menampilkan produk berdasarkan kategori
    public function filterByCategory($category)
    {
        $menu = Produk::where('kategori', $category)->get();
        return view('transaksi', compact('menu'));
    }

    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'tanggal_bayar' => 'required|date',
            'total_harga' => 'required|numeric',
            'qty' => 'required|integer',
            'orderList' => 'required',
            'pay' => 'required|numeric|min:' . $request->total_harga,
            'return_amount' => 'required|numeric',
        ]);

        // Decode JSON dari orderList
        $orderList = json_decode($request->orderList, true);
        if (!$orderList) {
            return back()->with('error', 'Format orderList tidak valid.');
        }

        // Simpan data transaksi ke dalam tabel `transaksis`
        $transaksi = new Transaksi();
        $transaksi->tanggal_bayar = $request->tanggal_bayar;
        $transaksi->total_harga = (float) $request->total_harga;
        $transaksi->pay = (float) $request->pay;
        $transaksi->return_amount = (float) $request->return_amount;
        $transaksi->save();

        // Simpan detail transaksi ke dalam tabel `detail_transaksi`
        foreach ($orderList as $order) {
            // Simpan detail transaksi
            DetailTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'produk_id'    => $order['id'],
                'total_harga'  => (float) ($order['price'] * $order['quantity']),
                'quantity'     => (int) $order['quantity'],
                'subtotal'     => (float) ($order['price'] * $order['quantity']),
            ]);

            // Mengurangi stok produk di tabel `produks`
            $produk = Produk::find($order['id']);
            if ($produk) {
                // Pastikan properti stok sesuai dengan nama kolom di database
                $produk->stok = $produk->stok - $order['quantity'];
                $produk->save();
            }
        }

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil disimpan!');
    }

    // Mencari produk berdasarkan nama atau kategori
    public function search(Request $request)
    {
        // Ambil parameter pencarian dan kategori
        $search = $request->input('search');
        $category = $request->input('category');

        // Query produk
        $query = Produk::query();

        // Jika ada input pencarian, filter berdasarkan nama produk
        if (!empty($search)) {
            $query->where('nama_produk', 'like', "%{$search}%");
        }

        // Jika ada kategori dan bukan 'all', filter berdasarkan kategori
        if (!empty($category) && $category !== 'all') {
            $query->where('kategori', $category);
        }

        // Ambil hasil query
        $menu = $query->get();

        // Kembalikan view dengan hasil pencarian dan filter
        return view('transaksi', compact('menu', 'search', 'category'));
    }
}
