@extends('user.dashboard.layout')

@section('title', 'My Points')
@section('page-title', 'My Points')

@section('content')
<!-- Points Balance -->
<div class="bg-gradient-to-r from-[#B8860B] to-[#DAA520] rounded-2xl p-8 text-white mb-8">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm opacity-80">Total Points</p>
            <h2 class="text-5xl font-bold">{{ number_format($points) }}</h2>
            <p class="mt-2">Points aktif yang bisa ditukarkan</p>
        </div>
        <div class="text-right">
            <i class="fas fa-coins text-6xl opacity-50"></i>
        </div>
    </div>
</div>

<!-- How to Earn Points -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-2xl p-6 shadow">
        <h3 class="font-bold text-lg text-[#3A2A20] mb-4">
            <i class="fas fa-plus-circle text-green-500 mr-2"></i>Cara Dapat Points
        </h3>
        <ul class="space-y-3">
            <li class="flex items-center justify-between py-2 border-b">
                <span>Setiap transaksi Rp 10.000</span>
                <span class="text-green-600 font-bold">+1 Point</span>
            </li>
            <li class="flex items-center justify-between py-2 border-b">
                <span>Member Premium 2x bonus</span>
                <span class="text-green-600 font-bold">+2 Points</span>
            </li>
            <li class="flex items-center justify-between py-2 border-b">
                <span>Member VIP 3x bonus</span>
                <span class="text-green-600 font-bold">+3 Points</span>
            </li>
            <li class="flex items-center justify-between py-2">
                <span>Review di Google/Instagram</span>
                <span class="text-green-600 font-bold">+50 Points</span>
            </li>
        </ul>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow">
        <h3 class="font-bold text-lg text-[#3A2A20] mb-4">
            <i class="fas fa-gift text-pink-500 mr-2"></i>Tukar Points
        </h3>
        <ul class="space-y-3">
            <li class="flex items-center justify-between py-2 border-b">
                <span>Es Teh Manis</span>
                <span class="text-[#7A3E22] font-bold">50 Points</span>
            </li>
            <li class="flex items-center justify-between py-2 border-b">
                <span>Kopi Susu</span>
                <span class="text-[#7A3E22] font-bold">80 Points</span>
            </li>
            <li class="flex items-center justify-between py-2 border-b">
                <span>Nasi Goreng</span>
                <span class="text-[#7A3E22] font-bold">150 Points</span>
            </li>
            <li class="flex items-center justify-between py-2">
                <span>Voucher Rp 50.000</span>
                <span class="text-[#7A3E22] font-bold">250 Points</span>
            </li>
        </ul>
    </div>
</div>

<!-- Rewards to Redeem -->
<h3 class="font-bold text-lg text-[#3A2A20] mb-4">Tukarkan Points Anda</h3>
<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
    @php
        $rewards = [
            ['name' => 'Es Teh Manis', 'points' => 50, 'icon' => 'fa-mug-hot'],
            ['name' => 'Kopi Susu', 'points' => 80, 'icon' => 'fa-coffee'],
            ['name' => 'Pisang Goreng', 'points' => 75, 'icon' => 'fa-cookie'],
            ['name' => 'Nasi Goreng', 'points' => 150, 'icon' => 'fa-bowl-rice'],
            ['name' => 'Ayam Bakar', 'points' => 200, 'icon' => 'fa-drumstick-bite'],
            ['name' => 'Voucher Rp 25K', 'points' => 125, 'icon' => 'fa-ticket'],
            ['name' => 'Voucher Rp 50K', 'points' => 250, 'icon' => 'fa-ticket'],
            ['name' => 'Free Booking', 'points' => 300, 'icon' => 'fa-calendar-check'],
        ];
    @endphp

    @foreach($rewards as $reward)
        <div class="bg-white rounded-xl p-4 shadow hover:shadow-lg transition">
            <div class="text-center">
                <i class="fas {{ $reward['icon'] }} text-3xl text-[#7A3E22] mb-3"></i>
                <h4 class="font-semibold text-sm">{{ $reward['name'] }}</h4>
                <p class="text-yellow-600 font-bold mt-1">{{ $reward['points'] }} Points</p>
                <button 
                    class="mt-3 w-full py-2 rounded-lg text-sm font-semibold transition
                        {{ $points >= $reward['points'] ? 'bg-[#7A3E22] text-white hover:bg-[#5C2E1A]' : 'bg-gray-200 text-gray-500 cursor-not-allowed' }}"
                    {{ $points < $reward['points'] ? 'disabled' : '' }}>
                    {{ $points >= $reward['points'] ? 'Tukar' : 'Tidak cukup' }}
                </button>
            </div>
        </div>
    @endforeach
</div>

<!-- Points History -->
<div class="mt-8">
    <h3 class="font-bold text-lg text-[#3A2A20] mb-4">Riwayat Points</h3>
    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <div class="p-8 text-center text-gray-500">
            <i class="fas fa-history text-4xl text-gray-300 mb-3"></i>
            <p>Riwayat points akan muncul di sini</p>
        </div>
    </div>
</div>
@endsection
