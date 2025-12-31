<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Joglo Lontar Cafe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-[#F5F0EB] min-h-screen">

    <!-- Sidebar -->
    <aside class="fixed top-0 left-0 w-64 h-full bg-[#3A2A20] text-white shadow-xl z-40">
        <div class="p-6 border-b border-[#5C4033]">
            <a href="/" class="text-xl font-bold text-[#FFA34C]">
                <i class="fas fa-leaf mr-2"></i>JOGLO LONTAR
            </a>
            <p class="text-xs text-gray-400 mt-1">Member Dashboard</p>
        </div>

        <nav class="p-4">
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('user.dashboard') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('user.dashboard') ? 'bg-[#7A3E22] text-white' : 'hover:bg-[#5C4033]' }}">
                        <i class="fas fa-home w-5"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.dashboard.membership') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('user.dashboard.membership*') ? 'bg-[#7A3E22] text-white' : 'hover:bg-[#5C4033]' }}">
                        <i class="fas fa-crown w-5 text-yellow-400"></i>
                        <span>Membership</span>
                        @if(!auth()->user()->membership || auth()->user()->membership->status !== 'active')
                            <span class="ml-auto bg-red-500 text-xs px-2 py-0.5 rounded-full">Activate</span>
                        @endif
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.dashboard.orders') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('user.dashboard.orders') ? 'bg-[#7A3E22] text-white' : 'hover:bg-[#5C4033]' }}">
                        <i class="fas fa-shopping-bag w-5"></i>
                        <span>My Orders</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.dashboard.bookings') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('user.dashboard.bookings') ? 'bg-[#7A3E22] text-white' : 'hover:bg-[#5C4033]' }}">
                        <i class="fas fa-calendar-alt w-5"></i>
                        <span>My Bookings</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.dashboard.points') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('user.dashboard.points') ? 'bg-[#7A3E22] text-white' : 'hover:bg-[#5C4033]' }}">
                        <i class="fas fa-coins w-5 text-yellow-400"></i>
                        <span>My Points</span>
                        <span class="ml-auto bg-[#7A3E22] text-xs px-2 py-0.5 rounded-full">{{ auth()->user()->points ?? 0 }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.dashboard.profile') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('user.dashboard.profile') ? 'bg-[#7A3E22] text-white' : 'hover:bg-[#5C4033]' }}">
                        <i class="fas fa-user w-5"></i>
                        <span>Profile</span>
                    </a>
                </li>
            </ul>


        </nav>

        <!-- User Info -->
        <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-[#5C4033]">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-[#7A3E22] flex items-center justify-center">
                    <i class="fas fa-user"></i>
                </div>
                <div class="flex-1">
                    <p class="font-semibold text-sm truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-400">Member</p>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="p-2 hover:bg-[#5C4033] rounded-lg" title="Logout">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="ml-64 p-8">
        <!-- Top Bar -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold text-[#3A2A20]">@yield('page-title', 'Dashboard')</h1>
            <div class="flex items-center gap-4">
                <a href="{{ route('user.cart.index') }}" class="relative">
                    <i class="fas fa-shopping-cart text-xl text-[#3A2A20]"></i>
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">0</span>
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Custom Scripts -->
    @stack('scripts')

</body>
</html>
