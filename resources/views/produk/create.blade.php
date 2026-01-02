<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('stylee.css') }}">
    <title>Document</title>
</head>
    <body>
    <div class="container">
        <h2>Tambah Produk</h2>

        <form action="{{ route('produk.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Nama Produk</label>
                <input type="text" name="nama_produk" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Kategori</label>
                <input type="text" name="kategori" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Stok</label>
                <input type="number" name="stok" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Harga</label>
                <input type="number" name="harga" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Diskon (%)</label>
                <input type="number" name="diskon" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
        <br>
        <a href="{{ route('produk.index') }}" class="btn btn-warning">Kembali</a>
    </div>
</body>
</html>