<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt #{{ $order->order_number }} - Joglo Lontar Cafe</title>
    <style>
        body { font-family: monospace; padding: 20px; max-width: 300px; margin: 0 auto; }
        .center { text-align: center; }
        .bold { font-weight: bold; }
        hr { border: none; border-top: 1px dashed #000; margin: 10px 0; }
        .row { display: flex; justify-content: space-between; }
        .total-row { font-size: 1.2em; font-weight: bold; }
        @media print { button { display: none; } }
    </style>
</head>
<body>

    <div class="center">
        <h2 style="margin:0;">JOGLO LONTAR CAFE</h2>
        <p style="margin:5px 0;">Jl. Raya Jogja No. 123</p>
        <p style="margin:5px 0;">Telp: (0274) 123-4567</p>
    </div>

    <hr>

    <div class="row">
        <span>No. Order</span>
        <span class="bold">{{ $order->order_number }}</span>
    </div>
    <div class="row">
        <span>Tanggal</span>
        <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
    </div>
    <div class="row">
        <span>Customer</span>
        <span>{{ $order->customer_name }}</span>
    </div>
    <div class="row">
        <span>Kasir</span>
        <span>{{ $order->user->name ?? 'Admin' }}</span>
    </div>

    <hr>

    @foreach($order->orderItems as $item)
        <div style="margin-bottom: 5px;">
            <div>{{ $item->barang->nama ?? 'Item' }}</div>
            <div class="row">
                <span>{{ $item->jumlah }} x {{ number_format($item->harga, 0, ',', '.') }}</span>
                <span>{{ number_format($item->subtotal, 0, ',', '.') }}</span>
            </div>
        </div>
    @endforeach

    <hr>

    <div class="row">
        <span>Subtotal</span>
        <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
    </div>

    @if($order->discount_amount > 0)
        <div class="row" style="color: green;">
            <span>Diskon ({{ $order->voucher_code }})</span>
            <span>- Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</span>
        </div>
    @endif

    <div class="row total-row">
        <span>TOTAL</span>
        <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
    </div>

    <div class="row">
        <span>Pembayaran</span>
        <span>{{ strtoupper($order->payment_method ?? 'CASH') }}</span>
    </div>

    <hr>

    <div class="center">
        <p>Terima kasih atas kunjungan Anda!</p>
        <p style="font-size: 0.8em;">www.joglolontarcafe.com</p>
    </div>

    <br>
    <button onclick="window.print()" style="width:100%; padding:10px; cursor:pointer;">
        🖨️ Print Receipt
    </button>

</body>
</html>
