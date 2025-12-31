@extends('user.dashboard.layout')

@section('title', 'Profile')
@section('page-title', 'Profile Settings')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Profile Card -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
            <div class="w-24 h-24 mx-auto bg-gradient-to-br from-[#7A3E22] to-[#B8860B] rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-user text-4xl text-white"></i>
            </div>
            <h3 class="text-xl font-bold text-[#3A2A20]">{{ $user->name }}</h3>
            <p class="text-gray-500">{{ $user->email }}</p>
            
            @if($user->membership && $user->membership->status === 'active')
                <div class="mt-4 inline-block px-4 py-2 bg-gradient-to-r from-[#B8860B] to-[#DAA520] text-white rounded-full">
                    <i class="fas fa-crown mr-1"></i>{{ ucfirst($user->membership->type) }} Member
                </div>
            @else
                <a href="{{ route('user.dashboard.membership') }}" class="mt-4 inline-block px-4 py-2 bg-gray-200 text-gray-700 rounded-full hover:bg-gray-300">
                    <i class="fas fa-crown mr-1"></i>Upgrade ke Member
                </a>
            @endif

            <div class="mt-6 pt-4 border-t grid grid-cols-2 gap-4 text-center">
                <div>
                    <p class="text-2xl font-bold text-[#7A3E22]">{{ $user->points ?? 0 }}</p>
                    <p class="text-xs text-gray-500">Points</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-[#7A3E22]">{{ $user->orders()->count() }}</p>
                    <p class="text-xs text-gray-500">Orders</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Form -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-[#3A2A20] mb-6">Edit Profile</h3>
            
            <form action="{{ route('user.dashboard.profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                               class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#7A3E22] focus:border-transparent"
                               required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" value="{{ $user->email }}"
                               class="w-full px-4 py-3 border rounded-lg bg-gray-100 cursor-not-allowed"
                               disabled>
                        <p class="text-xs text-gray-500 mt-1">Email tidak dapat diubah</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                        <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}"
                               class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#7A3E22] focus:border-transparent"
                               placeholder="08xxxxxxxxxx">
                        @error('phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                        <textarea name="address" rows="3"
                                  class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#7A3E22] focus:border-transparent"
                                  placeholder="Masukkan alamat lengkap">{{ old('address', $user->address) }}</textarea>
                        @error('address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex gap-4">
                    <button type="submit" class="px-6 py-3 bg-[#7A3E22] text-white rounded-lg font-semibold hover:bg-[#5C2E1A] transition">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <!-- Change Password -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mt-6">
            <h3 class="text-lg font-bold text-[#3A2A20] mb-6">Ubah Password</h3>
            
            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password Lama</label>
                        <input type="password" name="current_password"
                               class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#7A3E22]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                        <input type="password" name="password"
                               class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#7A3E22]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation"
                               class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#7A3E22]">
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="px-6 py-3 bg-gray-600 text-white rounded-lg font-semibold hover:bg-gray-700 transition">
                        <i class="fas fa-lock mr-2"></i>Ubah Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
