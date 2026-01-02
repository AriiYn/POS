<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function produk(Request $request)
    {
        $keyword = $request->input('keyword');

        $query = Produk::query();

        if ($keyword) {
            // Mengelompokkan kondisi pencarian agar OR berfungsi dengan benar
            $query->where(function($q) use ($keyword) {
                $q->where('nama_produk', 'like', "%$keyword%")
                ->orWhere('kategori', 'like', "%$keyword%")
                ->orWhere('stok', 'like', "%$keyword%")
                ->orWhere('harga', 'like', "%$keyword%")
                ->orWhere('diskon', 'like', "%$keyword%");
            });
        }

        // Urutkan data sehingga produk terbaru tampil di atas (asumsi id bertambah)
        $query->orderBy('id', 'desc');

        $produks = $query->get();

        return view('index', compact('produks', 'keyword'));
    }


    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'stok' => 'required|integer',
            'harga' => 'required|numeric',
            'diskon' => 'nullable|numeric|min:0|max:100',
        ]);

        Produk::create($request->all());

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Produk $produk)
    {
        return view('produk.edit', compact('produk'));
    }

    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'stok' => 'required|integer',
            'harga' => 'required|numeric',
            'diskon' => 'nullable|numeric|min:0|max:100',
        ]);

        $produk->update($request->all());

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Produk $produk)
    {
        $produk->delete();
        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}
