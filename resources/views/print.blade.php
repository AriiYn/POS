<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Print Struk Transaksi</title>
  <style>
    /* Import font dari Google Fonts (opsional) */
    @import url("https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap");

    /* Global reset dan font styling */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body {
      font-family: "Roboto", sans-serif;
      background: #f5f7fa;
      padding: 20px;
      color: #333;
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #2c3e50;
    }
    p {
      margin-bottom: 10px;
      font-size: 16px;
    }
    strong {
      color: #2c3e50;
    }
    hr {
      margin: 20px 0;
      border: 0;
      border-top: 2px solid #ecf0f1;
    }
    /* Styling untuk tabel */
    table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
    }
    thead {
      background: #2c3e50;
      color: #fff;
    }
    th, td {
      padding: 12px 15px;
      text-align: center;
      border: 1px solid #ddd;
    }
    tbody tr:nth-child(even) {
      background: #f9f9f9;
    }
    tbody tr:hover {
      background: #f1f1f1;
    }
    /* Tombol Print (jika diperlukan, meskipun window.print() otomatis dipanggil) */
    .btn-print {
      display: inline-block;
      background: #27ae60;
      color: #fff;
      padding: 10px 20px;
      text-decoration: none;
      border-radius: 4px;
      transition: background 0.3s ease;
    }
    .btn-print:hover {
      background: #219150;
    }
    /* Styling untuk tampilan print */
    @media print {
      body {
        background: #fff;
        padding: 0;
      }
      .btn-print {
        display: none;
      }
      table {
        box-shadow: none;
      }
    }
  </style>
</head>
  <body>
    <br>
    <h2>Detail Transaksi</h2>
    <p><strong>ID Transaksi :</strong> {{ $transaksi->id }}</p>
    <p><strong>Tanggal Transaksi:</strong> {{ \Carbon\Carbon::parse($transaksi->tanggal_bayar)->format('d-m-Y') }}</p>
    <hr />
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Produk</th>
          <th>Harga</th>
          <th>Quantity</th>
          <th>Subtotal</th>
        </tr>
      </thead>
      <tbody>
        @foreach($detailTransaksis as $detail)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $detail->produk->nama_produk }}</td>
          <td>Rp {{ number_format($detail->produk->total_harga, 0, ',', '.') }}</td>
          <td>{{ $detail->quantity }}</td>
          <td>
            Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <hr />
    <p>
      <strong>Total Quantity :</strong>
      {{ $detailTransaksis->sum('quantity') }}
    </p>
    <br>
    <p>
      <strong>Total Harga :
      Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</strong>
    </p>
    <p>
      <strong>Jumlah Bayar :</strong>
      Rp {{ number_format($transaksi->pay, 0, ',', '.') }}
    </p>
    <p>
      <strong>Kembalian :</strong>
      Rp {{ number_format($transaksi->return_amount, 0, ',', '.') }}
    </p>
    <br>
    <div style="text-align: center;">
      <p>Terimakasih Telah Belanja Disini!</p>
    </div>

    <!-- Tombol Print (opsional, karena fungsi print dipanggil otomatis) -->
    <div style="text-align: right;">
      <a href="javascript:window.print()" class="btn-print">Print Struk</a>
    </div>

    <script>
      // Otomatis memanggil fungsi print ketika halaman selesai dimuat
      window.print();
    </script>
  </body>
</html>
