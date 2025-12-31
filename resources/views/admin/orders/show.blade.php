@extends('admin.sidebar')

@section('container')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Order #{{ $order->order_number }}</h1>
        <a href="{{ route('admin.orders.index') }}" class="text-gray-600 hover:text-gray-800">
            <i class="fas fa-arrow-left mr-2"></i> Back to Orders
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Order Info -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4">Order Information</h2>
            
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Order Number</span>
                    <span class="font-semibold">{{ $order->order_number }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Customer</span>
                    <span>{{ $order->customer_name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Email</span>
                    <span>{{ $order->user->email ?? '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Date</span>
                    <span>{{ $order->created_at->format('d M Y H:i') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Status</span>
                    <span class="px-2 py-1 rounded text-xs
                        @if($order->status === 'completed') bg-green-100 text-green-800
                        @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                        @else bg-blue-100 text-blue-800
                        @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Payment Status</span>
                    <span class="px-2 py-1 rounded text-xs
                        @if($order->payment_status === 'paid') bg-green-100 text-green-800
                        @else bg-yellow-100 text-yellow-800
                        @endif">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Payment Method</span>
                    <span>{{ strtoupper($order->payment_method ?? '-') }}</span>
                </div>
            </div>
        </div>

        <!-- Price Summary -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4">Payment Summary</h2>
            
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Subtotal</span>
                    <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                </div>
                @if($order->discount_amount > 0)
                    <div class="flex justify-between text-green-600">
                        <span>Discount ({{ $order->voucher_code }})</span>
                        <span>- Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</span>
                    </div>
                @endif
                <hr>
                <div class="flex justify-between text-xl font-bold">
                    <span>Total</span>
                    <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="bg-white rounded-lg shadow mt-6 p-6">
        <h2 class="text-xl font-bold mb-4">Order Items</h2>
        
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left">Product</th>
                    <th class="px-4 py-2 text-center">Qty</th>
                    <th class="px-4 py-2 text-right">Price</th>
                    <th class="px-4 py-2 text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($order->orderItems as $item)
                    <tr>
                        <td class="px-4 py-3">{{ $item->barang->nama ?? 'Item' }}</td>
                        <td class="px-4 py-3 text-center">{{ $item->jumlah }}</td>
                        <td class="px-4 py-3 text-right">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-right font-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Actions -->
    <div class="mt-6 flex gap-4">
        @if($order->status === 'pending')
            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                @csrf
                <input type="hidden" name="status" value="processing">
                <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                    <i class="fas fa-play mr-2"></i> Start Processing
                </button>
            </form>
        @elseif($order->status === 'processing')
            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                @csrf
                <input type="hidden" name="status" value="completed">
                <button type="submit" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                    <i class="fas fa-check mr-2"></i> Mark as Completed
                </button>
            </form>
        @endif
    </div>
@endsection
