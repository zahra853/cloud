<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin - Joglo Lontar Cafe' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>

<body class="bg-[#F5F0EB]">
    <!-- Top Navbar -->
    <nav class="fixed top-0 z-50 w-full bg-[#3A2A20] border-b border-[#5C4033] shadow-lg">
        <div class="px-4 py-3 lg:px-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start rtl:justify-end">
                    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar"
                        aria-controls="logo-sidebar" type="button"
                        class="inline-flex items-center p-2 text-white rounded-lg sm:hidden hover:bg-[#5C4033] focus:outline-none">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                            </path>
                        </svg>
                    </button>
                    <a href="/" class="flex items-center gap-3 ms-2 md:me-24">
                        <i class="fas fa-leaf text-2xl text-[#FFA34C]"></i>
                        <span class="self-center text-xl font-bold text-white whitespace-nowrap">
                            JOGLO LONTAR
                        </span>
                        <span class="text-xs text-gray-400">Admin</span>
                    </a>
                </div>
                <div class="flex items-center gap-4">
                    <div class="hidden sm:flex items-center gap-2 text-white">
                        <span class="text-sm">{{ Auth::user()->name }}</span>
                        <span class="px-2 py-1 text-xs font-medium bg-[#7A3E22] rounded-full">
                            {{ Auth::user()->role }}
                        </span>
                    </div>
                    <div class="relative">
                        <button type="button"
                            class="flex text-sm bg-[#7A3E22] rounded-full focus:ring-4 focus:ring-[#5C4033]"
                            data-dropdown-toggle="dropdown-user">
                            <span class="sr-only">Open user menu</span>
                            <div class="w-8 h-8 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-white"></i>
                            </div>
                        </button>
                        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-lg"
                            id="dropdown-user">
                            <div class="px-4 py-3">
                                <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-sm text-gray-500 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            <ul class="py-1">
                                <li>
                                    <a href="/" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-home mr-2"></i>Homepage
                                    </a>
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="block">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-16 transition-transform -translate-x-full bg-[#3A2A20] border-r border-[#5C4033] sm:translate-x-0"
        aria-label="Sidebar">
        <div class="h-full px-3 py-4 overflow-y-auto">
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center p-3 rounded-lg text-white hover:bg-[#5C4033] group {{ Request::is('admin/dashboard*') ? 'bg-[#7A3E22]' : '' }}">
                        <i class="fas fa-gauge text-lg w-6"></i>
                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.pos.index') }}"
                        class="flex items-center p-3 rounded-lg text-white hover:bg-[#5C4033] group {{ Request::is('admin/pos*') ? 'bg-[#7A3E22]' : '' }}">
                        <i class="fas fa-cash-register text-lg w-6"></i>
                        <span class="ms-3">POS</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users.index') }}"
                        class="flex items-center p-3 rounded-lg text-white hover:bg-[#5C4033] group {{ Request::is('admin/users*') ? 'bg-[#7A3E22]' : '' }}">
                        <i class="fas fa-users text-lg w-6"></i>
                        <span class="ms-3">Users</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/barang"
                        class="flex items-center p-3 rounded-lg text-white hover:bg-[#5C4033] group {{ Request::is('admin/barang*') ? 'bg-[#7A3E22]' : '' }}">
                        <i class="fas fa-box text-lg w-6"></i>
                        <span class="ms-3">Products</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.orders.index') }}"
                        class="flex items-center p-3 rounded-lg text-white hover:bg-[#5C4033] group {{ Request::is('admin/orders*') ? 'bg-[#7A3E22]' : '' }}">
                        <i class="fas fa-shopping-cart text-lg w-6"></i>
                        <span class="ms-3">Orders</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.bookings.index') }}"
                        class="flex items-center p-3 rounded-lg text-white hover:bg-[#5C4033] group {{ Request::is('admin/bookings*') ? 'bg-[#7A3E22]' : '' }}">
                        <i class="fas fa-calendar text-lg w-6"></i>
                        <span class="ms-3">Bookings</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.vouchers.index') }}"
                        class="flex items-center p-3 rounded-lg text-white hover:bg-[#5C4033] group {{ Request::is('admin/vouchers*') ? 'bg-[#7A3E22]' : '' }}">
                        <i class="fas fa-ticket text-lg w-6"></i>
                        <span class="ms-3">Vouchers</span>
                    </a>
                </li>
            </ul>

            <!-- Bottom Section -->
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-[#5C4033]">
                <div class="flex items-center gap-3 text-white">
                    <div class="w-10 h-10 rounded-full bg-[#7A3E22] flex items-center justify-center">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-sm truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-400">Admin</p>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#7A3E22',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: "{{ session('error') }}",
                confirmButtonColor: '#7A3E22',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    <div class="p-6 sm:ml-64 mt-16">
        @yield('container')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</body>

</html>
