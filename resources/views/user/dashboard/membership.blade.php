@extends('user.dashboard.layout')

@section('title', 'Membership')
@section('page-title', 'Membership')

@section('content')
<!-- Success Alert -->
@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6" role="alert">
    <div class="flex items-center">
        <i class="fas fa-check-circle mr-2"></i>
        <span>{{ session('success') }}</span>
    </div>
</div>
@endif

@if(session('error'))
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6" role="alert">
    <div class="flex items-center">
        <i class="fas fa-exclamation-circle mr-2"></i>
        <span>{{ session('error') }}</span>
    </div>
</div>
@endif

@if(session('info'))
<div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded-lg mb-6" role="alert">
    <div class="flex items-center">
        <i class="fas fa-info-circle mr-2"></i>
        <span>{{ session('info') }}</span>
    </div>
</div>
@endif

<!-- Current Membership Status -->
@if(Auth::user()->is_member && Auth::user()->membership_expires_at && \Carbon\Carbon::parse(Auth::user()->membership_expires_at)->isFuture())
<div class="bg-gradient-to-r from-[#7A3E22] to-[#B8860B] rounded-2xl p-8 text-white mb-8">
    <div class="flex items-center justify-between">
        <div class="flex-1">
            <p class="text-sm opacity-80">Membership Aktif</p>
            <h2 class="text-3xl font-bold">{{ ucfirst(Auth::user()->membership_type) }} Member</h2>
            <p class="mt-2">Berlaku hingga {{ \Carbon\Carbon::parse(Auth::user()->membership_expires_at)->format('d M Y') }}</p>
            <div class="mt-4 flex gap-3">
                @if(Auth::user()->membership_type !== 'vip')
                <button onclick="showUpgradeOptions()" class="px-4 py-2 bg-white text-[#7A3E22] rounded-lg font-semibold hover:bg-gray-100 transition">
                    <i class="fas fa-arrow-up mr-2"></i>Upgrade Plan
                </button>
                @endif
                <button onclick="cancelMembership()" class="px-4 py-2 bg-red-500 text-white rounded-lg font-semibold hover:bg-red-600 transition">
                    <i class="fas fa-times mr-2"></i>Cancel Membership
                </button>
            </div>
        </div>
        <div class="text-right">
            <i class="fas fa-crown text-6xl opacity-50"></i>
        </div>
    </div>
</div>

<!-- Hide plan selection when membership is active -->
<div id="upgrade-section" style="display: none;">
@else
<div class="bg-gray-100 rounded-2xl p-8 mb-8">
    <div class="text-center">
        <i class="fas fa-crown text-5xl text-gray-400 mb-4"></i>
        <h2 class="text-2xl font-bold text-[#3A2A20]">Anda Belum Memiliki Membership</h2>
        <p class="text-gray-600 mt-2">Pilih paket membership di bawah untuk menikmati berbagai keuntungan!</p>
    </div>
</div>
@endif

<!-- Membership Plans -->
@if(!Auth::user()->is_member || !Auth::user()->membership_expires_at || \Carbon\Carbon::parse(Auth::user()->membership_expires_at)->isPast())
<h3 class="text-xl font-bold text-[#3A2A20] mb-6">Pilih Paket Membership</h3>
@else
<h3 class="text-xl font-bold text-[#3A2A20] mb-6">Upgrade Membership</h3>
<p class="text-gray-600 mb-6">Anda hanya dapat upgrade ke plan yang lebih tinggi. Membership saat ini: <strong>{{ ucfirst(Auth::user()->membership_type) }}</strong></p>
@endif

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Basic -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition">
        <div class="bg-gradient-to-br from-gray-500 to-gray-700 p-6 text-white text-center">
            <h4 class="text-2xl font-bold">Basic</h4>
            <p class="text-4xl font-bold mt-2">Rp 50.000</p>
            <p class="text-sm opacity-80">/ 1 Bulan</p>
        </div>
        <div class="p-6">
            <ul class="space-y-3">
                <li class="flex items-center gap-2">
                    <i class="fas fa-check text-green-500"></i>
                    <span>Diskon 5% setiap pembelian</span>
                </li>
                <li class="flex items-center gap-2">
                    <i class="fas fa-check text-green-500"></i>
                    <span>Points reward 1x</span>
                </li>
                <li class="flex items-center gap-2">
                    <i class="fas fa-check text-green-500"></i>
                    <span>Priority booking</span>
                </li>
                <li class="flex items-center gap-2 text-gray-400">
                    <i class="fas fa-times"></i>
                    <span>Free birthday cake</span>
                </li>
                <li class="flex items-center gap-2 text-gray-400">
                    <i class="fas fa-times"></i>
                    <span>Exclusive event access</span>
                </li>
            </ul>
            @php
                $currentMembershipLevel = 0;
                if (Auth::user()->is_member && Auth::user()->membership_type) {
                    $levels = ['basic' => 1, 'premium' => 2, 'vip' => 3];
                    $currentMembershipLevel = $levels[Auth::user()->membership_type] ?? 0;
                }
                $basicLevel = 1;
                $isDisabled = $currentMembershipLevel >= $basicLevel;
            @endphp
            
            <button onclick="payMembership('basic', 50000)" 
                    class="w-full py-3 rounded-lg font-semibold transition {{ $isDisabled ? 'bg-gray-400 text-gray-600 cursor-not-allowed' : 'bg-gray-600 text-white hover:bg-gray-700' }} mt-6"
                    {{ $isDisabled ? 'disabled' : '' }}>
                @if($isDisabled)
                    Plan Saat Ini
                @else
                    Pilih Basic
                @endif
            </button>
        </div>
    </div>

    <!-- Premium -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition transform scale-105 border-2 border-[#B8860B]">
        <div class="bg-[#B8860B] text-center py-1 text-white text-sm font-bold">
            PALING POPULER
        </div>
        <div class="bg-gradient-to-br from-[#B8860B] to-[#8B6914] p-6 text-white text-center">
            <h4 class="text-2xl font-bold">Premium</h4>
            <p class="text-4xl font-bold mt-2">Rp 100.000</p>
            <p class="text-sm opacity-80">/ 3 Bulan</p>
        </div>
        <div class="p-6">
            <ul class="space-y-3">
                <li class="flex items-center gap-2">
                    <i class="fas fa-check text-green-500"></i>
                    <span>Diskon 10% setiap pembelian</span>
                </li>
                <li class="flex items-center gap-2">
                    <i class="fas fa-check text-green-500"></i>
                    <span>Points reward 2x</span>
                </li>
                <li class="flex items-center gap-2">
                    <i class="fas fa-check text-green-500"></i>
                    <span>Priority booking</span>
                </li>
                <li class="flex items-center gap-2">
                    <i class="fas fa-check text-green-500"></i>
                    <span>Free birthday cake</span>
                </li>
                <li class="flex items-center gap-2 text-gray-400">
                    <i class="fas fa-times"></i>
                    <span>Exclusive event access</span>
                </li>
            </ul>
            @php
                $premiumLevel = 2;
                $isDisabled = $currentMembershipLevel >= $premiumLevel;
            @endphp
            
            <button onclick="payMembership('premium', 100000)" 
                    class="w-full py-3 rounded-lg font-semibold transition {{ $isDisabled ? 'bg-gray-400 text-gray-600 cursor-not-allowed' : 'bg-[#B8860B] text-white hover:bg-[#9A7209]' }} mt-6"
                    {{ $isDisabled ? 'disabled' : '' }}>
                @if($isDisabled && Auth::user()->membership_type === 'premium')
                    Plan Saat Ini
                @elseif($isDisabled)
                    Tidak Bisa Downgrade
                @else
                    Pilih Premium
                @endif
            </button>
        </div>
    </div>

    <!-- VIP -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition">
        <div class="bg-gradient-to-br from-[#7A3E22] to-[#5C2E1A] p-6 text-white text-center">
            <h4 class="text-2xl font-bold">VIP</h4>
            <p class="text-4xl font-bold mt-2">Rp 250.000</p>
            <p class="text-sm opacity-80">/ 1 Tahun</p>
        </div>
        <div class="p-6">
            <ul class="space-y-3">
                <li class="flex items-center gap-2">
                    <i class="fas fa-check text-green-500"></i>
                    <span>Diskon 15% setiap pembelian</span>
                </li>
                <li class="flex items-center gap-2">
                    <i class="fas fa-check text-green-500"></i>
                    <span>Points reward 3x</span>
                </li>
                <li class="flex items-center gap-2">
                    <i class="fas fa-check text-green-500"></i>
                    <span>Priority booking</span>
                </li>
                <li class="flex items-center gap-2">
                    <i class="fas fa-check text-green-500"></i>
                    <span>Free birthday cake</span>
                </li>
                <li class="flex items-center gap-2">
                    <i class="fas fa-check text-green-500"></i>
                    <span>Exclusive event access</span>
                </li>
            </ul>
            @php
                $vipLevel = 3;
                $isDisabled = $currentMembershipLevel >= $vipLevel;
            @endphp
            
            <button onclick="payMembership('vip', 250000)" 
                    class="w-full py-3 rounded-lg font-semibold transition {{ $isDisabled ? 'bg-gray-400 text-gray-600 cursor-not-allowed' : 'bg-[#7A3E22] text-white hover:bg-[#5C2E1A]' }} mt-6"
                    {{ $isDisabled ? 'disabled' : '' }}>
                @if($isDisabled)
                    Plan Saat Ini
                @else
                    Pilih VIP
                @endif
            </button>
        </div>
    </div>
</div>
<!-- Benefits Section -->
<div class="mt-12">
    <h3 class="text-xl font-bold text-[#3A2A20] mb-6">Keuntungan Member</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-xl shadow text-center">
            <i class="fas fa-percent text-4xl text-[#7A3E22] mb-4"></i>
            <h4 class="font-bold">Diskon Spesial</h4>
            <p class="text-sm text-gray-600 mt-2">Dapatkan potongan harga setiap kali berbelanja</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow text-center">
            <i class="fas fa-coins text-4xl text-yellow-500 mb-4"></i>
            <h4 class="font-bold">Kumpulkan Points</h4>
            <p class="text-sm text-gray-600 mt-2">Tukarkan points dengan menu favorit</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow text-center">
            <i class="fas fa-birthday-cake text-4xl text-pink-500 mb-4"></i>
            <h4 class="font-bold">Birthday Treat</h4>
            <p class="text-sm text-gray-600 mt-2">Dapatkan kue gratis di hari ulang tahun</p>
        </div>
    </div>
</div>

@if(Auth::user()->is_member && Auth::user()->membership_expires_at && \Carbon\Carbon::parse(Auth::user()->membership_expires_at)->isFuture())
</div> <!-- End upgrade-section -->
@endif

@endsection

@push('scripts')
<!-- Midtrans Snap -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Payment function
    window.payMembership = function(type, price) {
        // Show loading
        Swal.fire({
            title: 'Memproses...',
            text: 'Membuat pembayaran',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Create payment
        fetch('{{ route("user.dashboard.membership.activate") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                type: type,
                price: price
            })
        })
        .then(response => response.json())
        .then(data => {
            Swal.close();
            if (data.success) {
                const orderNumber = data.order_number;
                
                // Open Midtrans popup
                snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        console.log('Payment success:', result);
                        
                        // Show loading while confirming
                        Swal.fire({
                            title: 'Mengaktifkan Membership...',
                            text: 'Mohon tunggu',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        
                        // Confirm payment to activate membership
                        fetch('{{ route("user.dashboard.membership.confirm") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                order_number: orderNumber
                            })
                        })
                        .then(response => response.json())
                        .then(confirmData => {
                            Swal.close();
                            if (confirmData.success) {
                                // Reload page to show updated membership status
                                window.location.reload();
                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Perhatian',
                                    text: confirmData.message || 'Pembayaran berhasil, membership akan segera aktif',
                                    showConfirmButton: true,
                                    confirmButtonText: 'OK',
                                    buttonsStyling: false,
                                    customClass: {
                                        confirmButton: 'bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 font-medium text-sm'
                                    }
                                }).then(() => {
                                    window.location.reload();
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Confirm error:', error);
                            // Still reload - webhook might handle it
                            window.location.reload();
                        });
                    },
                    onPending: function(result) {
                        console.log('Payment pending:', result);
                        Swal.fire({
                            icon: 'info',
                            title: 'Pembayaran Pending',
                            text: 'Silahkan selesaikan pembayaran Anda',
                            showConfirmButton: true,
                            confirmButtonText: 'OK',
                            buttonsStyling: false,
                            customClass: {
                                confirmButton: 'bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 font-medium text-sm'
                            }
                        }).then(() => {
                            window.location.reload();
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
                        console.log('Payment popup closed');
                        // User closed the popup without completing payment
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: data.message || 'Terjadi kesalahan',
                    showConfirmButton: true,
                    confirmButtonText: 'OK',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600 font-medium text-sm'
                    }
                });
            }
        })
        .catch(error => {
            Swal.close();
            console.error('Error:', error);
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
    };

    // Show upgrade options
    window.showUpgradeOptions = function() {
        const upgradeSection = document.getElementById('upgrade-section');
        if (upgradeSection.style.display === 'none') {
            upgradeSection.style.display = 'block';
            upgradeSection.scrollIntoView({ behavior: 'smooth' });
        } else {
            upgradeSection.style.display = 'none';
        }
    };

    // Cancel membership
    window.cancelMembership = function() {
        Swal.fire({
            title: 'Cancel Membership?',
            text: 'Apakah Anda yakin ingin membatalkan membership? Anda akan kehilangan semua benefit member.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Cancel',
            cancelButtonText: 'Batal',
            buttonsStyling: false,
            customClass: {
                confirmButton: 'bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600 font-medium text-sm mx-2',
                cancelButton: 'bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 font-medium text-sm mx-2'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Mohon tunggu',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Send cancel request
                fetch('{{ route("user.dashboard.membership.cancel") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    Swal.close();
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Membership Dibatalkan',
                            text: 'Membership Anda telah dibatalkan',
                            showConfirmButton: true,
                            confirmButtonText: 'OK',
                            buttonsStyling: false,
                            customClass: {
                                confirmButton: 'bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 font-medium text-sm'
                            }
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: data.message || 'Terjadi kesalahan',
                            showConfirmButton: true,
                            confirmButtonText: 'OK',
                            buttonsStyling: false,
                            customClass: {
                                confirmButton: 'bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600 font-medium text-sm'
                            }
                        });
                    }
                })
                .catch(error => {
                    Swal.close();
                    console.error('Error:', error);
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
        });
    };
});
</script>
@endpush