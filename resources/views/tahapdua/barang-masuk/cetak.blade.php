<!DOCTYPE html>
<html>

<head>
    <title>Surat Barang Masuk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #000;
            margin: 40px;
        }

        h2 {
            text-align: center;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .info p {
            margin: 2px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 13px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        .total-row {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .terbilang {
            margin-top: 10px;
            font-style: italic;
        }
    </style>
</head>

<body onload="window.print()">

    <h2>Surat Barang Masuk</h2>

    <div class="info">
        <p><strong>Asal Barang:</strong> {{ $barang_masuk->suplier }}</p>
        <p><strong>Penerima:</strong> {{ $barang_masuk->user->name }}</p>
        <p><strong>Kategori:</strong> {{ $barang_masuk->kategori->nama }} |
            <strong>Sub Kategori:</strong> {{ $barang_masuk->subkategori->nama }}
        </p>
        <p><strong>Tanggal:</strong> {{ $barang_masuk->created_at->format('d/m/Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Tgl. Expired</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach ($barang_masuk->items as $k => $item)
                @php
                    $subtotal = $item->price * $item->qty;
                    $total += $subtotal;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ 'ATK' . str_pad($k + 1, 4, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->tgl_expired ? $item->tgl_expired->format('d/m/Y') : '-' }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ $item->satuan }}</td>
                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="7" style="text-align: right">Total Keseluruhan</td>
                <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <p class="terbilang">
        <strong>Terbilang:</strong> {{ ucwords(terbilang($total)) }} Rupiah
    </p>
    <script>
        window.onafterprint = function() {
            window.close();
        };
    </script>
</body>

</html>
