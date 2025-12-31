@extends('user.navbar')

@section('container')
<div class="max-w-4xl mx-auto py-8 px-4">
    <h1 class="text-3xl font-bold mb-6">Shopping Cart</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(count($cart) > 0)
        <div class="bg-white rounded-lg shadow">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left">Product</th>
                        <th class="px-6 py-3 text-center">Price</th>
                        <th class="px-6 py-3 text-center">Qty</th>
                        <th class="px-6 py-3 text-right">Subtotal</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @php $total = 0; @endphp
                    @foreach($cart as $id => $item)
                        @php $subtotal = $item['price'] * $item['qty']; $total += $subtotal; @endphp
                        <tr>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    @if($item['image'])
                                        <img src="{{ asset('storage/' . $item['image']) }}" class="w-16 h-16 object-cover rounded">
                                    @else
                                        <div class="w-16 h-16 bg-gray-100 rounded flex items-center justify-center">
                                            <i class="fas fa-utensils text-gray-400"></i>
                                        </div>
                                    @endif
                                    <span class="font-semibold">{{ $item['name'] }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <form action="{{ route('user.cart.update', $id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="action" value="decrease">
                                        <button class="w-8 h-8 bg-gray-200 rounded hover:bg-gray-300">-</button>
                                    </form>
                                    <span class="w-8 text-center">{{ $item['qty'] }}</span>
                                    <form action="{{ route('user.cart.update', $id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="action" value="increase">
                                        <button class="w-8 h-8 bg-gray-200 rounded hover:bg-gray-300">+</button>
                                    </form>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right font-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <form action="{{ route('user.cart.remove', $id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Voucher & Checkout -->
        <div class="mt-6 bg-white rounded-lg shadow p-6">
            <form action="{{ route('user.checkout') }}" method="POST">
                @csrf
                
                <div class="flex gap-4 mb-6">
                    <input type="text" name="voucher_code" placeholder="Enter voucher code" 
                           class="flex-1 px-4 py-2 border rounded-lg" value="{{ session('voucher_code') }}">
                    <button type="button" onclick="applyVoucher()" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                        Apply
                    </button>
                </div>
                
                @if(session('discount'))
                    <div class="bg-green-50 p-4 rounded-lg mb-4">
                        <p class="text-green-700">
                            <i class="fas fa-check-circle mr-2"></i>
                            Voucher applied: {{ session('voucher_code') }} - Discount Rp {{ number_format(session('discount'), 0, ',', '.') }}
                        </p>
                    </div>
                @endif

                <div class="border-t pt-4">
                    <div class="flex justify-between mb-2">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    @if(session('discount'))
                        <div class="flex justify-between mb-2 text-green-600">
                            <span>Discount</span>
                            <span>- Rp {{ number_format(session('discount'), 0, ',', '.') }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between text-xl font-bold">
                        <span>Total</span>
                        <span>Rp {{ number_format($total - (session('discount') ?? 0), 0, ',', '.') }}</span>
                    </div>
                </div>

                <button type="submit" class="w-full mt-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700">
                    <i class="fas fa-shopping-bag mr-2"></i> Proceed to Checkout
                </button>
            </form>
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 mb-4">Your cart is empty</p>
            <a href="{{ route('menu') }}" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Browse Menu
            </a>
        </div>
    @endif
</div>

<script>
function applyVoucher() {
    const code = document.querySelector('input[name="voucher_code"]').value;
    if (code) {
        window.location.href = '{{ route("user.cart") }}?voucher=' + code;
    }
}
</script>
@endsection
