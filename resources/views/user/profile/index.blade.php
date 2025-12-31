@extends('user.navbar')

@section('container')
<div class="max-w-4xl mx-auto py-8 px-4">
    <h1 class="text-3xl font-bold mb-6">My Profile</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Profile Info -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4">Account Information</h2>
            
            <div class="space-y-4">
                <div>
                    <label class="text-sm text-gray-500">Name</label>
                    <p class="font-semibold">{{ $user->name }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-500">Email</label>
                    <p class="font-semibold">{{ $user->email }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-500">Phone</label>
                    <p class="font-semibold">{{ $user->phone ?? '-' }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-500">Address</label>
                    <p class="font-semibold">{{ $user->address ?? '-' }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-500">Member Since</label>
                    <p class="font-semibold">{{ $user->created_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Membership Status -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4">Membership Status</h2>
            
            @if($user->isActiveMember())
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fas fa-crown text-amber-500"></i>
                        <span class="font-bold text-green-800">Active Member</span>
                    </div>
                    <p class="text-green-700 text-sm">
                        Valid until: {{ $user->membership_expires_at->format('d M Y') }}
                    </p>
                </div>
                <div class="bg-amber-50 p-4 rounded-lg">
                    <p class="text-sm font-semibold text-amber-800 mb-2">Member Benefits:</p>
                    <ul class="text-sm text-amber-700 space-y-1">
                        <li>✓ Access to exclusive vouchers (MEMBER10, MEMBER20)</li>
                        <li>✓ Special member discounts</li>
                        <li>✓ Priority booking</li>
                    </ul>
                </div>
            @else
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-4">
                    <p class="text-gray-600">You are not a member yet.</p>
                </div>
                <a href="{{ route('membership.register') }}" 
                   class="block w-full text-center bg-amber-500 text-white py-3 rounded-lg font-semibold hover:bg-amber-600">
                    Become a Member - Rp 100.000/year
                </a>
            @endif
        </div>
    </div>

    <!-- Edit Profile Form -->
    <div class="bg-white rounded-lg shadow p-6 mt-6">
        <h2 class="text-xl font-bold mb-4">Edit Profile</h2>
        
        <form action="{{ route('user.profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Name</label>
                    <input type="text" name="name" value="{{ $user->name }}" 
                           class="w-full px-4 py-2 border rounded-lg" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" 
                           class="w-full px-4 py-2 border rounded-lg bg-gray-100" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Phone</label>
                    <input type="tel" name="phone" value="{{ $user->phone }}" 
                           class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-1">Address</label>
                    <textarea name="address" rows="2" 
                              class="w-full px-4 py-2 border rounded-lg">{{ $user->address }}</textarea>
                </div>
            </div>
            
            <button type="submit" class="mt-4 px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                <i class="fas fa-save mr-2"></i> Save Changes
            </button>
        </form>
    </div>
</div>
@endsection
