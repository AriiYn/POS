<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <title>Detail Transaksi</title>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 30px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            border-bottom: 2px solid #007bff;
            display: inline-block;
            padding-bottom: 5px;
        }
        .btn {
            border-radius: 20px;
        }
        .table {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('transaksi.index') }}" class="btn btn-danger mb-3">Back</a> |
        <h2>Transaksi</h2>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-primary">
                    <tr>
                        <th>NO</th>
                        <th>Tanggal Transaksi</th>
                        <th>Total Harga</th>
                        <th>Jumlah Bayar</th>
                        <th>Kembalian</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $index => $transaction)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($transaction->tanggal_bayar)->format('d-m-Y') }}</td>
                            <td>Rp. {{ number_format($transaction->total_harga, 0) }}</td>
                            <td>Rp. {{ number_format($transaction->pay, 0) }}</td>
                            <td>Rp. {{ number_format($transaction->return_amount, 0) }}</td>
                            <td>
                                <a href="{{ route('detail-transaksi.print', $transaction->id) }}" target="_blank" class="btn btn-warning btn-sm">Print</a>
                                <button class="btn btn-info btn-sm" onclick="toggleDetails({{ $index }})">Detail</button>
                            </td>
                        </tr>
                        <tr id="details-{{ $index }}" style="display: none;">
                            <td colspan="6">
                                <div class="p-3 bg-light border rounded">
                                    <h5>Detail Transaksi</h5>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>NO</th>
                                                <th>Nama Produk</th>
                                                <th>Harga</th>
                                                <th>Quantity</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($details->where('transaksi_id', $transaction->id) as $detail)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $detail->produk->nama_produk }}</td>
                                                    <td>Rp. {{ number_format($detail->produk->total_harga, 0) }}</td>
                                                    <td>{{ $detail->quantity }}</td>
                                                    <td>Rp. {{ number_format($detail->subtotal, 0) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function toggleDetails(index) {
            const detailsRow = document.getElementById(`details-${index}`);
            if (detailsRow.style.display === "none") {
                detailsRow.style.display = "table-row";
            } else {
                detailsRow.style.display = "none";
            }
        }
    </script>
</body>
</html>