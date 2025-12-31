<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History - Joglo Lontar Cafe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
</head>
<body class="bg-gray-100">

    @include('admin.sidebar')

    <div class="ml-64 p-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Transaction History</h1>
            <a href="{{ route('admin.pos.index') }}" class="bg-amber-500 text-white px-4 py-2 rounded-lg hover:bg-amber-600">
                <i class="fas fa-cash-register mr-2"></i> Open POS
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order #</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Items</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payment</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($transactions as $order)
                        <tr>
                            <td class="px-6 py-4 font-semibold">{{ $order->order_number }}</td>
                            <td class="px-6 py-4">{{ $order->customer_name }}</td>
                            <td class="px-6 py-4">{{ $order->orderItems->count() }} items</td>
                            <td class="px-6 py-4 font-bold text-green-600">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded text-xs uppercase
                                    @if($order->payment_method === 'cash') bg-green-100 text-green-800
                                    @elseif($order->payment_method === 'card') bg-blue-100 text-blue-800
                                    @else bg-purple-100 text-purple-800
                                    @endif">
                                    {{ $order->payment_method ?? 'cash' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.pos.receipt', $order) }}" 
                                   target="_blank"
                                   class="text-blue-600 hover:underline">
                                    <i class="fas fa-receipt"></i> Receipt
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                No transactions yet
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($transactions->hasPages())
            <div class="mt-4">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>

</body>
</html>
