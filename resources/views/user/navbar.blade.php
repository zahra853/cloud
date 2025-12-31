<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Deresya Store' }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
</head>

<body class="bg-gray-100">

    <!-- NAVBAR -->
    <nav class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-screen-xl flex items-center justify-between mx-auto p-4">

            <!-- LOGO -->
            <a href="/" class="flex items-center space-x-3">
                <i class="text-2xl text-gray-800 fa-solid fa-store"></i>
                <span class="text-2xl font-bold text-gray-900">Deresya Store</span>
            </a>

            <!-- RIGHT SIDE -->
            <div class="flex items-center space-x-4">

                <!-- CART ICON -->
                <a href="{{ route('user.cart.index') }}" class="relative p-2 text-gray-600 hover:text-gray-900">
                    <i class="fas fa-shopping-cart text-xl"></i>
                    <span id="cart-count" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                        {{ session('cart') ? count(session('cart')) : 0 }}
                    </span>
                </a>

                {{-- ================= IF LOGGED IN ================= --}}
                @auth
                    <!-- PROFILE DROPDOWN BUTTON -->
                    <button type="button"
                        class="flex items-center text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300"
                        id="user-menu-button" data-dropdown-toggle="user-dropdown">

                        <img class="w-9 h-9 rounded-full"
                            src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}"
                            alt="user photo">
                    </button>

                    <!-- DROPDOWN -->
                    <div id="user-dropdown"
                        class="z-50 hidden my-4 w-44 bg-white rounded-lg shadow divide-y divide-gray-100">

                        <div class="px-4 py-3">
                            <span class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</span>
                            <p class="text-sm text-gray-500 truncate">{{ Auth::user()->email }}</p>
                            @if(Auth::user()->isActiveMember())
                                <span class="text-xs bg-amber-100 text-amber-800 px-2 py-0.5 rounded">Member</span>
                            @endif
                        </div>

                        <ul class="py-2 text-sm text-gray-700">
                            @if (Auth::user()->role == 'admin')
                                <li>
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 hover:bg-gray-100">
                                        <i class="fas fa-tachometer-alt mr-2"></i> Admin Dashboard
                                    </a>
                                </li>
                            @endif

                            <li>
                                <a href="{{ route('user.profile') }}" class="block px-4 py-2 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2"></i> My Profile
                                </a>
                            </li>
                            
                            <li>
                                <a href="{{ route('user.orders') }}" class="block px-4 py-2 hover:bg-gray-100">
                                    <i class="fas fa-shopping-bag mr-2"></i> My Orders
                                </a>
                            </li>
                            
                            <li>
                                <a href="{{ route('user.bookings') }}" class="block px-4 py-2 hover:bg-gray-100">
                                    <i class="fas fa-calendar mr-2"></i> My Bookings
                                </a>
                            </li>

                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100 text-red-600">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Log Out
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>

                {{-- ================= IF NOT LOGGED IN ================= --}}
                @else
                    <a href="/login"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                        Login
                    </a>
                @endauth

                <!-- MOBILE MENU BUTTON -->
                <button data-collapse-toggle="navbar-user" type="button"
                    class="md:hidden p-2 w-10 h-10 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 focus:ring-2 focus:ring-gray-200">

                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>

                </button>
            </div>

            <!-- NAV MENU -->
            <div class="hidden md:flex items-center md:order-1" id="navbar-user">
                <ul class="flex space-x-8 font-medium text-gray-700">

                    <li>
                        <a href="/homepage"
                            class="{{ Request::is('homepage*') ? 'text-blue-700 font-bold' : 'hover:text-blue-700' }}">
                            Home
                        </a>
                    </li>

                    <li>
                        <a href="/product"
                            class="{{ Request::is('product*') ? 'text-blue-700 font-bold' : 'hover:text-blue-700' }}">
                            Product
                        </a>
                    </li>

                </ul>
            </div>

        </div>
    </nav>

    <!-- CONTENT -->
    @yield('container')

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

</body>
</html>
