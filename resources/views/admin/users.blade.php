@extends('admin.sidebar')

@section('container')
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">User Management</h1>
        <p class="text-gray-500">Manage registered users and their subscription status</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-sm font-medium text-gray-500">Total Users</h3>
            <p class="text-2xl font-bold text-gray-900">{{ $users->count() }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-sm font-medium text-gray-500">Active Members</h3>
            <p class="text-2xl font-bold text-green-600">{{ $users->where('is_active_member', true)->count() }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-sm font-medium text-gray-500">Expired Members</h3>
            <p class="text-2xl font-bold text-red-600">{{ $users->where('is_member', true)->where('is_active_member', false)->count() }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-sm font-medium text-gray-500">Non-Members</h3>
            <p class="text-2xl font-bold text-gray-600">{{ $users->where('is_member', false)->count() }}</p>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">All Users</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Membership Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Membership Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expires At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Spent</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if($user['avatar'])
                                            <img class="h-10 w-10 rounded-full" src="{{ $user['avatar'] }}" alt="{{ $user['name'] }}">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                <span class="text-sm font-medium text-gray-700">{{ substr($user['name'], 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $user['name'] }}</div>
                                        <div class="text-sm text-gray-500">{{ $user['email'] }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($user['is_active_member'])
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        Active Member
                                    </span>
                                @elseif($user['is_member'])
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-red-400" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        Expired Member
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-gray-400" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        Non-Member
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $user['membership_type'] ? ucfirst($user['membership_type']) : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($user['membership_expires_at'])
                                    {{ \Carbon\Carbon::parse($user['membership_expires_at'])->format('M d, Y') }}
                                    @if(\Carbon\Carbon::parse($user['membership_expires_at'])->isPast())
                                        <span class="text-red-500 text-xs">(Expired)</span>
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                Rp {{ number_format($user['total_spent'], 0, ',', '.') }}
                                @if($user['total_transactions'] > 0)
                                    <div class="text-xs text-gray-500">{{ $user['total_transactions'] }} transactions</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($user['created_at'])->format('M d, Y') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if($users->isEmpty())
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No users found</h3>
            <p class="mt-1 text-sm text-gray-500">No users have registered yet.</p>
        </div>
    @endif
@endsection