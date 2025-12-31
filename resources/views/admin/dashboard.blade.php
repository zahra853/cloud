@extends('admin.sidebar')

@section('container')
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Overview</h1>
        <p class="text-gray-500">Welcome back, {{ Auth::user()->name }}!</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Pending Orders -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-6 rounded-xl shadow-lg text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-80">Pending Orders</p>
                    <h3 class="text-3xl font-bold">{{ $pendingOrders }}</h3>
                </div>
                <i class="fas fa-clock text-4xl opacity-50"></i>
            </div>
        </div>

        <!-- Pending Bookings -->
        <div class="bg-gradient-to-br from-amber-500 to-amber-600 p-6 rounded-xl shadow-lg text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-80">Pending Bookings</p>
                    <h3 class="text-3xl font-bold">{{ $pendingBookings }}</h3>
                </div>
                <i class="fas fa-calendar-alt text-4xl opacity-50"></i>
            </div>
        </div>

        <!-- Total Products -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 p-6 rounded-xl shadow-lg text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-80">Total Products</p>
                    <h3 class="text-3xl font-bold">{{ $totalProducts }}</h3>
                </div>
                <i class="fas fa-box text-4xl opacity-50"></i>
            </div>
        </div>

        <!-- Total Users -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-6 rounded-xl shadow-lg text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-80">Total Users</p>
                    <h3 class="text-3xl font-bold">{{ $totalUsers }}</h3>
                </div>
                <i class="fas fa-users text-4xl opacity-50"></i>
            </div>
        </div>
    </div>

    <!-- Visitor Analytics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Today's Visitors -->
        <div class="bg-white p-6 rounded-xl shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Today's Visitors</p>
                    <h3 class="text-2xl font-bold text-indigo-600">{{ $todayVisitors }}</h3>
                    <p class="text-xs text-gray-500">{{ $todayPageViews }} page views</p>
                </div>
                <i class="fas fa-eye text-3xl text-indigo-300"></i>
            </div>
        </div>

        <!-- This Week -->
        <div class="bg-white p-6 rounded-xl shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">This Week</p>
                    <h3 class="text-2xl font-bold text-cyan-600">{{ $weekVisitors }}</h3>
                    <p class="text-xs text-gray-500">{{ $weekPageViews }} page views</p>
                </div>
                <i class="fas fa-chart-line text-3xl text-cyan-300"></i>
            </div>
        </div>

        <!-- This Month -->
        <div class="bg-white p-6 rounded-xl shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">This Month</p>
                    <h3 class="text-2xl font-bold text-teal-600">{{ $monthVisitors }}</h3>
                    <p class="text-xs text-gray-500">{{ $monthPageViews }} page views</p>
                </div>
                <i class="fas fa-calendar-week text-3xl text-teal-300"></i>
            </div>
        </div>
    </div>

    <!-- Membership Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Total Members</h3>
            <p class="text-3xl font-bold text-purple-600">{{ $totalMembers }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Active Members</h3>
            <p class="text-3xl font-bold text-green-600">{{ $activeMembers }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Membership Revenue</h3>
            <p class="text-3xl font-bold text-yellow-600">Rp {{ number_format($membershipRevenue, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Visitor Chart -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Visitor Analytics (Last 7 Days)</h3>
            <canvas id="visitorChart" width="400" height="200"></canvas>
        </div>

        <!-- Device Stats -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Device Breakdown</h3>
            <div class="space-y-3">
                @foreach($deviceStats as $device)
                    <div class="flex items-center justify-between">
                        <span class="capitalize text-gray-700">{{ $device->device_type }}</span>
                        <span class="font-semibold text-gray-900">{{ $device->count }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Top Pages -->
    <div class="bg-white p-6 rounded-xl shadow mb-8">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Top Pages (Last 7 Days)</h3>
        <div class="space-y-2">
            @foreach($topPages as $page)
                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-700">{{ $page->page_title }}</span>
                    <span class="font-semibold text-gray-900">{{ $page->views }} views</span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Revenue & Orders Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Today's Revenue</h3>
            <p class="text-3xl font-bold text-green-600">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Total Orders</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $totalOrders }}</p>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Orders -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Recent Orders</h3>
            <div class="space-y-3">
                @forelse($recentOrders as $order)
                    <div class="border-l-4 border-blue-500 pl-4 py-2 bg-gray-50 rounded-r">
                        <p class="font-semibold text-gray-800">{{ $order->order_number }}</p>
                        <p class="text-sm text-gray-600">{{ $order->customer_name }} - Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No recent orders</p>
                @endforelse
            </div>
            <a href="{{ route('admin.orders.index') }}" class="block mt-4 text-blue-600 hover:underline text-sm">
                View all orders →
            </a>
        </div>

        <!-- Recent Bookings -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Recent Bookings</h3>
            <div class="space-y-3">
                @forelse($recentBookings as $booking)
                    <div class="border-l-4 border-amber-500 pl-4 py-2 bg-gray-50 rounded-r">
                        <p class="font-semibold text-gray-800">{{ $booking->customer_name }}</p>
                        <p class="text-sm text-gray-600">{{ $booking->number_of_people }} people - {{ $booking->booking_date }} {{ $booking->booking_time }}</p>
                        <span class="inline-block mt-1 text-xs px-2 py-0.5 rounded 
                            @if($booking->status === 'confirmed') bg-green-100 text-green-800
                            @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No recent bookings</p>
                @endforelse
            </div>
            <a href="{{ route('admin.bookings.index') }}" class="block mt-4 text-blue-600 hover:underline text-sm">
                View all bookings →
            </a>
        </div>
    </div>

    <!-- Pending Approvals Alert -->
    @if($pendingOrders > 0 || $pendingBookings > 0)
    <div class="mt-8 bg-red-50 border border-red-200 p-6 rounded-xl">
        <h3 class="text-lg font-semibold text-red-800 mb-4">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            Pending Approvals
        </h3>
        <div class="space-y-2">
            @if($pendingOrders > 0)
                <p class="text-red-700">
                    <i class="fas fa-shopping-cart mr-2"></i>
                    {{ $pendingOrders }} order(s) waiting for confirmation
                    <a href="{{ route('admin.orders.index') }}" class="ml-4 underline">Review →</a>
                </p>
            @endif
            @if($pendingBookings > 0)
                <p class="text-red-700">
                    <i class="fas fa-calendar mr-2"></i>
                    {{ $pendingBookings }} booking(s) waiting for approval
                    <a href="{{ route('admin.bookings.index') }}" class="ml-4 underline">Review →</a>
                </p>
            @endif
        </div>
    </div>
    @endif

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Visitor Chart
        const ctx = document.getElementById('visitorChart').getContext('2d');
        const visitorChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_column($visitorChartData, 'date')) !!},
                datasets: [{
                    label: 'Unique Visitors',
                    data: {!! json_encode(array_column($visitorChartData, 'visitors')) !!},
                    borderColor: 'rgb(99, 102, 241)',
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Page Views',
                    data: {!! json_encode(array_column($pageViewChartData, 'views')) !!},
                    borderColor: 'rgb(34, 197, 94)',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
