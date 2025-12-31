@extends('admin.sidebar')

@section('container')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Orders Management</h1>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order #</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Items</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payment</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-semibold">{{ $order->order_number }}</td>
                        <td class="px-6 py-4">
                            <p class="font-medium">{{ $order->customer_name }}</p>
                            <p class="text-sm text-gray-500">{{ $order->user->email ?? '-' }}</p>
                        </td>
                        <td class="px-6 py-4">{{ $order->orderItems->count() }} items</td>
                        <td class="px-6 py-4 font-bold text-green-600">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-xs
                                @if($order->status === 'completed') bg-green-100 text-green-800
                                @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-xs
                                @if($order->payment_status === 'paid') bg-green-100 text-green-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.orders.show', $order) }}" 
                                   class="text-blue-600 hover:underline text-sm">
                                    Detail
                                </a>
                                @if($order->status === 'pending')
                                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="status" value="processing">
                                        <button type="submit" class="text-green-600 hover:underline text-sm">
                                            Process
                                        </button>
                                    </form>
                                @elseif($order->status === 'processing')
                                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="status" value="completed">
                                        <button type="submit" class="text-green-600 hover:underline text-sm">
                                            Complete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                            No orders yet
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    @endif
@endsection
