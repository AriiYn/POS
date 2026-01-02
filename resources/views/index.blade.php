<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <h2>Daftar Produk</h2>

        <form action="{{ route('produk.index') }}" method="GET" class="mb-3">
            <input type="text" name="keyword" class="form-control d-inline-block w-50" 
                value="{{ request('keyword') }}" placeholder="Cari produk..." required>
            <button type="submit" class="btn btn-primary">Cari</button>
            <a href="{{ route('produk.index') }}" class="btn btn-secondary">Reset</a>
        </form>
        <br>
        <a href="{{ route('transaksi.index') }}" class="btn btn-danger mb-3">Back</a>
        <a href="{{ route('produk.create') }}" class="btn btn-success mb-3">Tambah Produk</a>
        <br>
        <br>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Diskon (%)</th>
                <th>Total Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($produks as $produk)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $produk->nama_produk }}</td>
                <td>{{ $produk->kategori }}</td>
                <td>{{ $produk->stok }}</td>
                <td>Rp {{ number_format($produk->harga, 0) }}</td>
                <td>{{ $produk->diskon }}%</td>
                <td>Rp {{ number_format($produk->total_harga, 0) }}</td>
                <td>
                    <a href="{{ route('produk.edit', $produk->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('produk.destroy', $produk->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus produk ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
        </table>
    </div>
</body>
</html>