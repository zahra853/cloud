@extends('admin.sidebar')

@section('container')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Midtrans Snap JS -->
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>

<div class="flex gap-6" style="height: calc(100vh - 120px);">
    
    <!-- Products Section -->
    <div class="flex-1 overflow-y-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">POS System</h1>
        
        <!-- Categories -->
        <div class="flex gap-2 mb-6 flex-wrap">
            <button class="category-btn px-4 py-2 rounded-lg bg-blue-600 text-white" data-category="all">
                Semua
            </button>
            @foreach($categories as $category)
                <button class="category-btn px-4 py-2 rounded-lg bg-gray-200 hover:bg-blue-600 hover:text-white transition" 
                        data-category="{{ $category }}">
                    {{ $category }}
                </button>
            @endforeach
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4" id="products-grid">
            @forelse($products as $product)
                <div class="product-card bg-white rounded-xl shadow p-4 cursor-pointer hover:shadow-lg hover:scale-105 transition"
                     data-id="{{ $product->id }}"
                     data-name="{{ $product->name }}"
                     data-price="{{ $product->final_price }}"
                     data-original-price="{{ $product->price }}"
                     data-discount="{{ $product->discount }}"
                     data-category="{{ $product->category }}"
                     data-stock="{{ $product->stock }}"
                     onclick="addToCart(this)">
                    @if($product->image_url)
                        <img src="{{ $product->image_url }}" 
                             class="w-full h-24 object-cover rounded-lg mb-2"
                             onerror="this.onerror=null; this.src='https://via.placeholder.com/150?text=No+Image';">
                    @else
                        <div class="w-full h-24 bg-gray-100 rounded-lg mb-2 flex items-center justify-center">
                            <i class="fas fa-utensils text-3xl text-gray-300"></i>
                        </div>
                    @endif
                    <h3 class="font-semibold text-sm truncate text-gray-800">{{ $product->name }}</h3>
                    
                    @if($product->discount > 0)
                        <div class="flex flex-col">
                            <p class="text-xs text-gray-400 line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <p class="text-blue-600 font-bold">Rp {{ number_format($product->final_price, 0, ',', '.') }}</p>
                        </div>
                        <div class="absolute top-2 right-2 bg-red-500 text-white text-[10px] px-2 py-0.5 rounded-full">
                            {{ $product->discount }}% OFF
                        </div>
                    @else
                        <p class="text-blue-600 font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    @endif
                    
                    <p class="text-xs text-gray-500">Stok: {{ $product->stock }}</p>
                </div>
            @empty
                <div class="col-span-full text-center py-8 text-gray-500">
                    <i class="fas fa-box-open text-4xl mb-2"></i>
                    <p>No products available</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Cart Section -->
    <div class="w-80 bg-white rounded-xl shadow-lg flex flex-col">
        <div class="p-4 border-b bg-gray-50 rounded-t-xl">
            <h2 class="text-xl font-bold text-gray-800">Keranjang</h2>
            <input type="text" id="customer-name" placeholder="Nama Customer (opsional)"
                   class="w-full mt-2 px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Cart Items -->
        <div class="flex-1 overflow-y-auto p-4" id="cart-items">
            <p class="text-gray-400 text-center py-8">Belum ada item</p>
        </div>

        <!-- Voucher -->
        <div class="p-4 border-t">
            <div class="flex gap-2 items-center">
                <input type="text" id="voucher-code" placeholder="Kode Voucher"
                       class="flex-1 min-w-0 px-3 py-2 border rounded-lg text-sm uppercase">
                <button onclick="applyVoucher()" class="px-3 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 text-sm font-medium whitespace-nowrap">
                    Apply
                </button>
            </div>
            <p id="voucher-info" class="text-xs mt-1 text-green-600 hidden"></p>
        </div>

        <!-- Total & Payment -->
        <div class="p-4 border-t bg-gray-50 rounded-b-xl">
            <div class="flex justify-between mb-1">
                <span class="text-gray-600">Subtotal</span>
                <span id="subtotal">Rp 0</span>
            </div>
            <div class="flex justify-between mb-2 text-green-600" id="discount-row" style="display:none;">
                <span>Diskon</span>
                <span id="discount">- Rp 0</span>
            </div>
            <div class="flex justify-between text-xl font-bold mb-4">
                <span>Total</span>
                <span id="total" class="text-blue-600">Rp 0</span>
            </div>

            <div class="grid grid-cols-3 gap-2 mb-3">
                <button onclick="processPayment('cash')" class="py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 text-sm">
                    <i class="fas fa-money-bill"></i> Cash
                </button>
                <button onclick="processPayment('card')" class="py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 text-sm">
                    <i class="fas fa-credit-card"></i> Card
                </button>
                <button onclick="processPayment('midtrans')" class="py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600 text-sm">
                    <i class="fas fa-qrcode"></i> Midtrans
                </button>
            </div>

            <button onclick="clearCart()" class="w-full py-2 border border-red-500 text-red-500 rounded-lg hover:bg-red-50 text-sm">
                <i class="fas fa-trash mr-1"></i> Clear Cart
            </button>
        </div>
    </div>
</div>

<script>
    let cart = [];
    let appliedVoucher = null;
    let discountAmount = 0;

    function addToCart(element) {
        const id = element.dataset.id;
        const name = element.dataset.name;
        const price = parseFloat(element.dataset.price);
        const stock = parseInt(element.dataset.stock);

        const existing = cart.find(item => item.id === id);
        if (existing) {
            if (existing.qty >= stock) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Stok Tidak Cukup',
                    text: 'Stok produk ini sudah habis!',
                    showConfirmButton: true,
                    confirmButtonText: 'OK',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'bg-orange-500 text-white px-6 py-3 rounded-lg hover:bg-orange-600 font-medium text-sm'
                    }
                });
                return;
            }
            existing.qty++;
        } else {
            cart.push({ id, name, price, qty: 1, stock });
        }
        renderCart();
        
        // Toast notification
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: `${name} ditambahkan`,
            showConfirmButton: false,
            timer: 1500
        });
    }

    function updateQty(id, delta) {
        const item = cart.find(i => i.id === id);
        if (item) {
            item.qty += delta;
            if (item.qty <= 0) {
                cart = cart.filter(i => i.id !== id);
            } else if (item.qty > item.stock) {
                item.qty = item.stock;
                Swal.fire({
                    icon: 'warning',
                    title: 'Stok Tidak Cukup',
                    text: 'Jumlah melebihi stok yang tersedia',
                    showConfirmButton: true,
                    confirmButtonText: 'OK',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'bg-orange-500 text-white px-6 py-3 rounded-lg hover:bg-orange-600 font-medium text-sm'
                    }
                });
            }
        }
        renderCart();
    }

    function renderCart() {
        const container = document.getElementById('cart-items');
        if (cart.length === 0) {
            container.innerHTML = '<p class="text-gray-400 text-center py-8">Belum ada item</p>';
            document.getElementById('subtotal').textContent = 'Rp 0';
            document.getElementById('total').textContent = 'Rp 0';
            document.getElementById('discount-row').style.display = 'none';
            discountAmount = 0;
            appliedVoucher = null;
            return;
        }

        let html = '';
        let subtotal = 0;
        cart.forEach(item => {
            const itemTotal = item.price * item.qty;
            subtotal += itemTotal;
            html += `
                <div class="flex items-center gap-3 py-3 border-b">
                    <div class="flex-1">
                        <p class="font-semibold text-sm text-gray-800">${item.name}</p>
                        <p class="text-xs text-gray-500">Rp ${item.price.toLocaleString('id')} x ${item.qty}</p>
                    </div>
                    <div class="flex items-center gap-1">
                        <button onclick="updateQty('${item.id}', -1)" class="w-7 h-7 bg-gray-100 rounded hover:bg-gray-200 text-sm">-</button>
                        <span class="w-6 text-center text-sm">${item.qty}</span>
                        <button onclick="updateQty('${item.id}', 1)" class="w-7 h-7 bg-gray-100 rounded hover:bg-gray-200 text-sm">+</button>
                    </div>
                </div>
            `;
        });
        container.innerHTML = html;
        
        document.getElementById('subtotal').textContent = 'Rp ' + subtotal.toLocaleString('id');
        
        // Recalculate discount if voucher applied
        if (appliedVoucher) {
            if (appliedVoucher.discount_type === 'percentage') {
                discountAmount = subtotal * (appliedVoucher.discount_value / 100);
                if (appliedVoucher.max_discount && discountAmount > appliedVoucher.max_discount) {
                    discountAmount = appliedVoucher.max_discount;
                }
            } else {
                discountAmount = appliedVoucher.discount_value;
            }
        }
        
        const total = Math.max(0, subtotal - discountAmount);
        document.getElementById('total').textContent = 'Rp ' + total.toLocaleString('id');
        
        if (discountAmount > 0) {
            document.getElementById('discount-row').style.display = 'flex';
            document.getElementById('discount').textContent = '- Rp ' + discountAmount.toLocaleString('id');
        } else {
            document.getElementById('discount-row').style.display = 'none';
        }
    }

    function clearCart() {
        if (cart.length === 0) return;
        Swal.fire({
            title: 'Hapus Keranjang?',
            text: 'Semua item akan dihapus dari keranjang',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            buttonsStyling: false,
            customClass: {
                confirmButton: 'bg-red-500 text-white px-4 py-2 rounded-lg mx-2 hover:bg-red-600',
                cancelButton: 'bg-gray-500 text-white px-4 py-2 rounded-lg mx-2 hover:bg-gray-600'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                cart = [];
                appliedVoucher = null;
                discountAmount = 0;
                document.getElementById('voucher-code').value = '';
                document.getElementById('voucher-info').classList.add('hidden');
                renderCart();
            }
        });
    }

    function applyVoucher() {
        const code = document.getElementById('voucher-code').value.trim();
        if (!code) {
            Swal.fire({
                icon: 'warning',
                title: 'Kode Kosong',
                text: 'Masukkan kode voucher terlebih dahulu',
                showConfirmButton: true,
                confirmButtonText: 'OK',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'bg-orange-500 text-white px-6 py-3 rounded-lg hover:bg-orange-600 font-medium text-sm'
                }
            });
            return;
        }

        if (cart.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Keranjang Kosong',
                text: 'Tambah item terlebih dahulu',
                showConfirmButton: true,
                confirmButtonText: 'OK',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'bg-orange-500 text-white px-6 py-3 rounded-lg hover:bg-orange-600 font-medium text-sm'
                }
            });
            return;
        }

        const subtotal = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
        
        fetch('/api/voucher/validate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ code, subtotal })
        })
        .then(res => res.json())
        .then(data => {
            if (data.valid) {
                appliedVoucher = data.voucher;
                discountAmount = data.voucher.discount_amount;
                document.getElementById('voucher-info').textContent = 
                    `✓ ${data.voucher.name} - Diskon Rp ${discountAmount.toLocaleString('id')}`;
                document.getElementById('voucher-info').classList.remove('hidden');
                document.getElementById('voucher-info').classList.add('text-green-600');
                document.getElementById('voucher-info').classList.remove('text-red-600');
                renderCart();
                
                Swal.fire({
                    icon: 'success',
                    title: 'Voucher Diterapkan!',
                    text: `Diskon Rp ${discountAmount.toLocaleString('id')}`,
                    showConfirmButton: true,
                    confirmButtonText: 'OK',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 font-medium text-sm'
                    }
                });
            } else {
                document.getElementById('voucher-info').textContent = data.message || 'Voucher tidak valid';
                document.getElementById('voucher-info').classList.remove('hidden');
                document.getElementById('voucher-info').classList.remove('text-green-600');
                document.getElementById('voucher-info').classList.add('text-red-600');
                appliedVoucher = null;
                discountAmount = 0;
                renderCart();
            }
        })
        .catch(err => {
            console.error(err);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Gagal memvalidasi voucher',
                showConfirmButton: true,
                confirmButtonText: 'OK',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600 font-medium text-sm'
                }
            });
        });
    }

    function processPayment(method) {
        if (cart.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Keranjang Kosong',
                text: 'Tambah item terlebih dahulu',
                showConfirmButton: true,
                confirmButtonText: 'OK',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'bg-orange-500 text-white px-6 py-3 rounded-lg hover:bg-orange-600 font-medium text-sm'
                }
            });
            return;
        }

        if (method === 'midtrans') {
            Swal.fire({
                title: 'Proses Pembayaran Midtrans',
                text: 'Anda akan diarahkan ke halaman pembayaran Midtrans',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Lanjutkan',
                cancelButtonText: 'Batal',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'bg-[#7A3E22] text-white px-4 py-2 rounded-lg mx-2 hover:bg-[#5C2E19]',
                    cancelButton: 'bg-red-500 text-white px-4 py-2 rounded-lg mx-2 hover:bg-red-600'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    executePayment(method);
                }
            });
        } else {
            Swal.fire({
                title: 'Konfirmasi Pembayaran',
                text: `Metode: ${method.toUpperCase()}`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Proses',
                cancelButtonText: 'Batal',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'bg-[#7A3E22] text-white px-4 py-2 rounded-lg mx-2 hover:bg-[#5C2E19]',
                    cancelButton: 'bg-red-500 text-white px-4 py-2 rounded-lg mx-2 hover:bg-red-600'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    executePayment(method);
                }
            });
        }
    }

    function executePayment(method) {
        const formData = {
            customer_name: document.getElementById('customer-name').value || 'Walk-in Customer',
            payment_method: method,
            items: cart.map(item => ({
                barang_id: parseInt(item.id),
                quantity: item.qty
            })),
            voucher_code: appliedVoucher ? appliedVoucher.code : null,
        };

        Swal.fire({
            title: 'Memproses...',
            text: 'Mohon tunggu',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        fetch('{{ route("admin.pos.transaction") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(formData)
        })
        .then(res => res.json())
        .then(data => {
            Swal.close();
            
            if (data.success) {
                // If Midtrans and has snap_token, open Snap popup
                if (method === 'midtrans' && data.snap_token) {
                    window.snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            console.log('Payment success:', result);
                            Swal.fire({
                                icon: 'success',
                                title: 'Pembayaran Berhasil!',
                                html: `
                                    <p class="mb-2"><strong>Order:</strong> ${data.order_number}</p>
                                    <p class="mb-4"><strong>Total:</strong> Rp ${data.total.toLocaleString('id')}</p>
                                    <p class="text-sm text-gray-500">Silahkan cetak struk untuk pelanggan</p>
                                `,
                                showCancelButton: true,
                                confirmButtonText: '<i class="fas fa-print mr-1"></i> Cetak Struk',
                                cancelButtonText: 'Tutup',
                                buttonsStyling: false,
                                customClass: {
                                    confirmButton: 'bg-[#7A3E22] text-white px-6 py-3 rounded-lg hover:bg-[#5C2E19] font-medium text-sm mx-2',
                                    cancelButton: 'bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 font-medium text-sm mx-2'
                                },
                                reverseButtons: true
                            }).then((result) => {
                                resetCart();
                                if (result.isConfirmed) {
                                    window.open('/admin/pos/receipt/' + data.order_id, '_blank');
                                }
                            });
                        },
                        onPending: function(result) {
                            console.log('Payment pending:', result);
                            Swal.fire({
                                icon: 'info',
                                title: 'Pembayaran Pending',
                                text: 'Silahkan selesaikan pembayaran',
                                showConfirmButton: true,
                                confirmButtonText: 'OK',
                                buttonsStyling: false,
                                customClass: {
                                    confirmButton: 'bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 font-medium text-sm'
                                }
                            }).then(() => {
                                resetCart();
                            });
                        },
                        onError: function(result) {
                            console.log('Payment error:', result);
                            Swal.fire({
                                icon: 'error',
                                title: 'Pembayaran Gagal',
                                text: 'Terjadi kesalahan saat memproses pembayaran',
                                showConfirmButton: true,
                                confirmButtonText: 'OK',
                                buttonsStyling: false,
                                customClass: {
                                    confirmButton: 'bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600 font-medium text-sm'
                                }
                            });
                        },
                        onClose: function() {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Pembayaran Dibatalkan',
                                text: 'Anda menutup popup pembayaran',
                                showConfirmButton: true,
                                confirmButtonText: 'OK, Mengerti',
                                buttonsStyling: false,
                                customClass: {
                                    confirmButton: 'bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600 font-medium'
                                }
                            });
                        }
                    });
                } else {
                    // Cash/Card payment - show success
                    Swal.fire({
                        icon: 'success',
                        title: 'Transaksi Berhasil!',
                        html: `
                            <p class="mb-2"><strong>Order:</strong> ${data.order_number}</p>
                            <p class="mb-4"><strong>Total:</strong> Rp ${data.total.toLocaleString('id')}</p>
                            <p class="text-sm text-gray-500">Silahkan cetak struk untuk pelanggan</p>
                        `,
                        showCancelButton: true,
                        confirmButtonText: '<i class="fas fa-print mr-1"></i> Cetak Struk',
                        cancelButtonText: 'Tutup',
                        buttonsStyling: false,
                        customClass: {
                            confirmButton: 'bg-[#7A3E22] text-white px-6 py-3 rounded-lg hover:bg-[#5C2E19] font-medium text-sm mx-2',
                            cancelButton: 'bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 font-medium text-sm mx-2'
                        },
                        reverseButtons: true
                    }).then((result) => {
                        resetCart();
                        if (result.isConfirmed) {
                            window.open('/admin/pos/receipt/' + data.order_id, '_blank');
                        }
                    });
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: data.message || 'Terjadi kesalahan saat memproses transaksi',
                    showConfirmButton: true,
                    confirmButtonText: 'OK',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600 font-medium text-sm'
                    }
                });
            }
        })
        .catch(err => {
            console.error(err);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Terjadi kesalahan sistem',
                showConfirmButton: true,
                confirmButtonText: 'OK',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600 font-medium text-sm'
                }
            });
        });
    }

    function resetCart() {
        cart = [];
        appliedVoucher = null;
        discountAmount = 0;
        document.getElementById('voucher-code').value = '';
        document.getElementById('customer-name').value = '';
        document.getElementById('voucher-info').classList.add('hidden');
        renderCart();
    }

    // Category filter
    document.querySelectorAll('.category-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.category-btn').forEach(b => {
                b.classList.remove('bg-blue-600', 'text-white');
                b.classList.add('bg-gray-200');
            });
            this.classList.remove('bg-gray-200');
            this.classList.add('bg-blue-600', 'text-white');

            const category = this.dataset.category;
            document.querySelectorAll('.product-card').forEach(card => {
                if (category === 'all' || card.dataset.category === category) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection
