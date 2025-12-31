@extends('user.navbar')

@section('container')
<div class="max-w-4xl mx-auto py-8 px-4">
    <h1 class="text-3xl font-bold mb-6">My Orders</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($orders->count() > 0)
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="font-bold text-lg">{{ $order->order_number }}</p>
                            <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div class="text-right">
                            <span class="px-3 py-1 rounded text-sm
                                @if($order->status === 'completed') bg-green-100 text-green-800
                                @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                            <span class="ml-2 px-3 py-1 rounded text-sm
                                @if($order->payment_status === 'paid') bg-green-100 text-green-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                    </div>

                    <div class="border-t pt-4">
                        @foreach($order->orderItems as $item)
                            <div class="flex justify-between py-2">
                                <span>{{ $item->barang->nama ?? 'Item' }} x {{ $item->jumlah }}</span>
                                <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>

                    @if($order->discount_amount > 0)
                        <div class="flex justify-between py-2 text-green-600">
                            <span>Discount ({{ $order->voucher_code }})</span>
                            <span>- Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</span>
                        </div>
                    @endif

                    <div class="border-t pt-4 flex justify-between items-center">
                        <span class="font-bold text-lg">Total: Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        
                        @if($order->payment_status === 'pending')
                            <a href="#" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                                Pay Now
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        @if($orders->hasPages())
            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        @endif
    @else
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <i class="fas fa-shopping-bag text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 mb-4">You haven't made any orders yet</p>
            <a href="{{ route('menu') }}" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Browse Menu
            </a>
        </div>
    @endif
</div>
@endsection
