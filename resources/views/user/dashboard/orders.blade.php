@extends('user.dashboard.layout')

@section('title', 'My Orders')
@section('page-title', 'My Orders')

@section('content')
<!-- Order Form Section -->
<div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
    <div class="p-4 border-b bg-gradient-to-r from-[#7A3E22] to-[#5C2E1A] text-white">
        <h3 class="font-bold text-lg flex items-center gap-2">
            <i class="fas fa-utensils"></i>
            Pesan Makanan
        </h3>
    </div>
    
    <div class="p-6">
        <!-- Menu Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-6" id="menu-grid">
            @foreach($menus as $menu)
            <div class="border rounded-xl overflow-hidden hover:shadow-lg transition cursor-pointer menu-item {{ $menu->stock <= 0 ? 'opacity-50' : '' }}"
                 data-id="{{ $menu->id }}"
                 data-name="{{ $menu->name }}"
                 data-price="{{ $menu->price }}"
                 data-stock="{{ $menu->stock }}"
                 onclick="{{ $menu->stock > 0 ? 'addToCart(this)' : '' }}">
                <div class="h-32 bg-gray-200 overflow-hidden">
                    @if($menu->image_url)
                    <img src="{{ asset($menu->image_url) }}" alt="{{ $menu->name }}" class="w-full h-full object-cover">
                    @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                        <i class="fas fa-image text-3xl"></i>
                    </div>
                    @endif
                </div>
                <div class="p-3">
                    <h4 class="font-semibold text-sm truncate">{{ $menu->name }}</h4>
                    <p class="text-[#7A3E22] font-bold text-sm">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                    @if($menu->stock <= 0)
                    <span class="text-xs text-red-500">Habis</span>
                    @else
                    <span class="text-xs text-gray-500">Stok: {{ $menu->stock }}</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <!-- Cart Section -->
        <div class="border-t pt-6">
            <h4 class="font-bold text-lg mb-4 flex items-center gap-2">
                <i class="fas fa-shopping-cart text-[#7A3E22]"></i>
                Keranjang
            </h4>
            <div id="cart-items" class="space-y-3 mb-4">
                <p class="text-gray-500 text-center py-4" id="empty-cart">Keranjang kosong</p>
            </div>
            
            <div id="cart-summary" class="hidden border-t pt-4">
                <div class="flex justify-between mb-2">
                    <span>Subtotal</span>
                    <span id="subtotal">Rp 0</span>
                </div>
                <div class="flex justify-between font-bold text-lg mb-4">
                    <span>Total</span>
                    <span id="total" class="text-[#7A3E22]">Rp 0</span>
                </div>
                <button onclick="submitOrder()" class="w-full py-3 bg-[#7A3E22] text-white rounded-lg font-semibold hover:bg-[#5C2E1A] transition">
                    <i class="fas fa-check mr-2"></i>Pesan Sekarang
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Order History -->
<div class="bg-white rounded-2xl shadow-lg overflow-hidden">
    <div class="p-4 border-b bg-gray-50">
        <h3 class="font-bold text-lg text-[#3A2A20]">Riwayat Pesanan</h3>
    </div>

    @forelse($orders as $order)
        <div class="p-6 border-b hover:bg-gray-50 transition">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <p class="font-bold text-lg text-[#3A2A20]">{{ $order->order_number }}</p>
                    <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div class="text-right">
                    <p class="font-bold text-xl text-[#7A3E22]">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                    <div class="flex gap-2 mt-1">
                        <span class="inline-block px-3 py-1 text-xs rounded-full 
                            {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 
                               ($order->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                        <span class="inline-block px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-700">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="mt-4 bg-gray-50 rounded-lg p-4">
                <p class="text-sm font-semibold mb-2">Items:</p>
                <div class="space-y-2">
                    @foreach($order->orderItems as $item)
                        <div class="flex justify-between text-sm">
                            <span>{{ $item->barang->name ?? 'Item' }} x {{ $item->quantity }}</span>
                            <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @empty
        <div class="p-8 text-center">
            <i class="fas fa-shopping-bag text-4xl text-gray-300 mb-3"></i>
            <p class="text-gray-500">Belum ada pesanan</p>
        </div>
    @endforelse

    @if($orders->hasPages())
        <div class="p-4 border-t">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
let cart = [];

function addToCart(element) {
    const id = element.dataset.id;
    const name = element.dataset.name;
    const price = parseInt(element.dataset.price);
    const stock = parseInt(element.dataset.stock);
    
    const existingItem = cart.find(item => item.id === id);
    
    if (existingItem) {
        if (existingItem.quantity < stock) {
            existingItem.quantity++;
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Stok Terbatas',
                text: 'Stok tidak mencukupi',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'bg-[#7A3E22] text-white px-6 py-3 rounded-lg'
                }
            });
            return;
        }
    } else {
        cart.push({ id, name, price, quantity: 1, stock });
    }
    
    renderCart();
}

function updateQuantity(id, change) {
    const item = cart.find(item => item.id === id);
    if (item) {
        item.quantity += change;
        if (item.quantity <= 0) {
            cart = cart.filter(i => i.id !== id);
        } else if (item.quantity > item.stock) {
            item.quantity = item.stock;
        }
    }
    renderCart();
}

function removeFromCart(id) {
    cart = cart.filter(item => item.id !== id);
    renderCart();
}

function renderCart() {
    const cartItems = document.getElementById('cart-items');
    const cartSummary = document.getElementById('cart-summary');
    const emptyCart = document.getElementById('empty-cart');
    
    if (cart.length === 0) {
        cartItems.innerHTML = '<p class="text-gray-500 text-center py-4" id="empty-cart">Keranjang kosong</p>';
        cartSummary.classList.add('hidden');
        return;
    }
    
    let html = '';
    let subtotal = 0;
    
    cart.forEach(item => {
        const itemTotal = item.price * item.quantity;
        subtotal += itemTotal;
        html += `
            <div class="flex items-center justify-between bg-gray-50 p-3 rounded-lg">
                <div class="flex-1">
                    <p class="font-semibold text-sm">${item.name}</p>
                    <p class="text-xs text-gray-500">Rp ${item.price.toLocaleString('id-ID')}</p>
                </div>
                <div class="flex items-center gap-2">
                    <button onclick="updateQuantity('${item.id}', -1)" class="w-8 h-8 bg-gray-200 rounded-full hover:bg-gray-300">-</button>
                    <span class="w-8 text-center">${item.quantity}</span>
                    <button onclick="updateQuantity('${item.id}', 1)" class="w-8 h-8 bg-gray-200 rounded-full hover:bg-gray-300">+</button>
                    <button onclick="removeFromCart('${item.id}')" class="w-8 h-8 text-red-500 hover:text-red-700">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <p class="font-bold text-sm ml-4 w-24 text-right">Rp ${itemTotal.toLocaleString('id-ID')}</p>
            </div>
        `;
    });
    
    cartItems.innerHTML = html;
    document.getElementById('subtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
    document.getElementById('total').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
    cartSummary.classList.remove('hidden');
}

function submitOrder() {
    if (cart.length === 0) return;
    
    Swal.fire({
        title: 'Memproses...',
        text: 'Membuat pesanan',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });
    
    fetch('{{ route("user.dashboard.orders.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ items: cart })
    })
    .then(response => response.json())
    .then(data => {
        Swal.close();
        if (data.success && data.snap_token) {
            snap.pay(data.snap_token, {
                onSuccess: function(result) {
                    window.location.reload();
                },
                onPending: function(result) {
                    window.location.reload();
                },
                onError: function(result) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Pembayaran Gagal',
                        text: 'Silahkan coba lagi',
                        buttonsStyling: false,
                        customClass: { confirmButton: 'bg-red-500 text-white px-6 py-3 rounded-lg' }
                    });
                },
                onClose: function() {}
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: data.message || 'Terjadi kesalahan',
                buttonsStyling: false,
                customClass: { confirmButton: 'bg-red-500 text-white px-6 py-3 rounded-lg' }
            });
        }
    })
    .catch(error => {
        Swal.close();
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Terjadi kesalahan sistem',
            buttonsStyling: false,
            customClass: { confirmButton: 'bg-red-500 text-white px-6 py-3 rounded-lg' }
        });
    });
}
</script>
@endpush