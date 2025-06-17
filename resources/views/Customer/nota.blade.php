<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nota Laundry - {{ $order->id_pesanan }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .title { font-size: 24px; font-weight: bold; }
        .subtitle { font-size: 16px; }
        .divider { border-top: 1px dashed #000; margin: 15px 0; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { padding: 8px; text-align: left; }
        .text-right { text-align: right; }
        .footer { margin-top: 30px; font-size: 12px; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Laundry Barokah </div>
        <div class="subtitle">Jln.Proklamasi, Depok, Jawa Barat </div>
        <div class="subtitle">Telp: 0812-3456-7890</div>
    </div>
    
    <div class="divider"></div>
    
    <table class="table">
        <tr>
            <th width="30%">No. Pesanan</th>
            <td>: {{ $order->id_pesanan }}</td>
            <th width="30%">Tanggal</th>
            <td>: {{ $order->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <th>Nama Pelanggan</th>
            <td>: {{ $order->customer->nama_panjang }}</td>
            <th>Telepon</th>
            <td>: {{ $order->customer->tlp }}</td>
        </tr>
    </table>
    
    <div class="divider"></div>
    
    <table class="table">
        <thead>
            <tr>
                <th>Layanan</th>
                <th>Berat (kg)</th>
                <th class="text-right">Harga</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $order->layanan->nama_layanan }}</td>
                <td>{{ $order->berat }}</td>
                <td class="text-right">Rp {{ number_format($order->layanan->harga, 0, ',', '.') }}/kg</td>
                <td class="text-right">Rp {{ number_format($order->price, 0, ',', '.') }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-right">Total</th>
                <th class="text-right">Rp {{ number_format($order->price, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>
    
    <div class="divider"></div>
    
    <div>
        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
        <p><strong>Estimasi Selesai:</strong> {{ $order->tglPengambilan ? $order->tglPengambilan->format('d/m/Y') : '-' }}</p>
    </div>
    
    <div class="footer">
        <p>Terima kasih telah menggunakan layanan kami</p>
        <p>Barang yang sudah dicuci tidak dapat ditukar atau dikembalikan</p>
    </div>
</body>
</html>