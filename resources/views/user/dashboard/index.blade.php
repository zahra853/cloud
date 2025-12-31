@extends('user.dashboard.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Membership Card -->
    <div class="bg-gradient-to-br from-[#7A3E22] to-[#5C2E1A] text-white rounded-2xl p-6 shadow-lg">
        <div class="flex items-center gap-3 mb-3">
            <i class="fas fa-crown text-2xl text-yellow-400"></i>
            <span class="font-semibold">Membership</span>
        </div>
        @if($membership && $membership->is_active)
            <p class="text-2xl font-bold">{{ ucfirst($membership->type) }}</p>
            <p class="text-sm text-gray-300">Aktif hingga {{ $membership->expires_at->format('d M Y') }}</p>
        @else
            <p class="text-lg font-bold">Belum Aktif</p>
            <a href="{{ route('user.dashboard.membership') }}" class="inline-block mt-2 bg-yellow-500 text-black px-4 py-1 rounded-full text-sm font-semibold hover:bg-yellow-400">
                Aktivasi Sekarang
            </a>
        @endif
    </div>

    <!-- Points Card -->
    <div class="bg-white rounded-2xl p-6 shadow-lg">
        <div class="flex items-center gap-3 mb-3">
            <i class="fas fa-coins text-2xl text-yellow-500"></i>
            <span class="font-semibold text-gray-600">Points</span>
        </div>
        <p class="text-3xl font-bold text-[#3A2A20]">{{ number_format($points) }}</p>
        <p class="text-sm text-gray-500">Poin tersedia</p>
    </div>

    <!-- Orders Card -->
    <div class="bg-white rounded-2xl p-6 shadow-lg">
        <div class="flex items-center gap-3 mb-3">
            <i class="fas fa-shopping-bag text-2xl text-blue-500"></i>
            <span class="font-semibold text-gray-600">Total Orders</span>
        </div>
        <p class="text-3xl font-bold text-[#3A2A20]">{{ $totalOrders }}</p>
        <p class="text-sm text-gray-500">Pesanan</p>
    </div>

    <!-- Bookings Card -->
    <div class="bg-white rounded-2xl p-6 shadow-lg">
        <div class="flex items-center gap-3 mb-3">
            <i class="fas fa-calendar-check text-2xl text-green-500"></i>
            <span class="font-semibold text-gray-600">Reservations</span>
        </div>
        <p class="text-3xl font-bold text-[#3A2A20]">{{ $totalBookings }}</p>
        <p class="text-sm text-gray-500">Reservasi</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Orders -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="p-4 border-b bg-gray-50 flex justify-between items-center">
            <h3 class="font-bold text-lg text-[#3A2A20]">Pesanan Terbaru</h3>
            <a href="{{ route('user.dashboard.orders') }}" class="text-blue-600 hover:underline text-sm">
                Lihat Semua
            </a>
        </div>
        <div class="p-4">
            @forelse($recentOrders as $order)
                <div class="flex items-center justify-between py-3 border-b last:border-0">
                    <div>
                        <p class="font-semibold text-sm">{{ $order->order_number }}</p>
                        <p class="text-xs text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-[#7A3E22]">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                        <span class="inline-block px-2 py-0.5 text-xs rounded-full 
                            {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">Belum ada pesanan</p>
            @endforelse
        </div>
    </div>

    <!-- Upcoming Bookings -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="p-4 border-b bg-gray-50 flex justify-between items-center">
            <h3 class="font-bold text-lg text-[#3A2A20]">Reservasi Mendatang</h3>
            <a href="{{ route('user.dashboard.bookings') }}" class="text-blue-600 hover:underline text-sm">
                Lihat Semua
            </a>
        </div>
        <div class="p-4">
            @forelse($upcomingBookings as $booking)
                <div class="flex items-center justify-between py-3 border-b last:border-0">
                    <div>
                        <p class="font-semibold text-sm">
                            <i class="fas fa-calendar-alt text-[#7A3E22] mr-1"></i>
                            {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}
                        </p>
                        <p class="text-xs text-gray-500">
                            <i class="fas fa-clock mr-1"></i>
                            {{ $booking->booking_time }} - {{ $booking->number_of_people }} orang
                        </p>
                    </div>
                    <span class="inline-block px-3 py-1 text-xs rounded-full 
                        {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                        {{ ucfirst($booking->status) }}
                    </span>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">Tidak ada reservasi mendatang</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="mt-8">
    <h3 class="font-bold text-lg text-[#3A2A20] mb-4">Quick Actions</h3>
    <div class="grid grid-cols-2 gap-4">
        <a href="{{ route('user.dashboard.membership') }}" class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition text-center">
            <i class="fas fa-crown text-3xl text-yellow-500 mb-2"></i>
            <p class="font-semibold">Membership</p>
        </a>
        <a href="{{ route('user.dashboard.points') }}" class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition text-center">
            <i class="fas fa-gift text-3xl text-pink-500 mb-2"></i>
            <p class="font-semibold">Redeem Points</p>
        </a>
    </div>
</div>
@endsection
