<!doctype html>
<html class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');
        * { font-family: "Montserrat", sans-serif; }
    </style>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cafe: {
                            100: '#F8F1E7',
                            300: '#D9C4A9',
                            500: '#B27A4C',
                            700: '#6E4B2E'
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="h-full">

<div class="grid grid-cols-1 md:grid-cols-2 h-screen">

    <!-- LEFT SIDE -->
    <div class="hidden md:block relative">
        <img src="{{ asset('images/homepage/gambar2.png') }}"
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/40"></div>

        <!-- Back ke homepage -->
        <a href="{{ url('/') }}"
           class="absolute top-6 left-6 text-white text-3xl font-bold z-20">
            &larr;
        </a>

        <div class="absolute inset-0 flex flex-col justify-center pl-16 z-10">
            <h1 class="text-4xl font-bold text-white max-w-md leading-tight">
                Selamat Datang di Joglo Lontar
            </h1>
            <p class="text-white mt-4 max-w-sm">
                Nikmati pengalaman kuliner dengan suasana tradisional khas Jogja.
            </p>
        </div>
    </div>

    <!-- RIGHT SIDE (LOGIN CARD) -->
    <div class="flex items-center justify-center bg-cafe-100 p-8 relative">

        <!-- Back (mobile) -->
        <a href="{{ url('/') }}"
           class="absolute top-6 left-6 text-cafe-700 text-2xl font-bold md:hidden">
            &larr;
        </a>

        <div class="w-full max-w-md bg-white shadow-xl rounded-3xl p-10 border border-cafe-300">

            <h2 class="text-3xl font-bold text-cafe-700 mb-2 text-center">Login</h2>
            <p class="text-gray-500 text-sm mb-8 text-center">
                Silakan masuk untuk melanjutkan
            </p>

            @if ($errors->has('login_error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ $errors->first('login_error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">Email</label>
                    <input type="email" name="email"
                           value="{{ old('email') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-cafe-500"
                           required>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">Password</label>
                    <input type="password" name="password"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-cafe-500"
                           required>
                </div>

                <button type="submit"
                        class="w-full bg-cafe-500 text-white py-3 rounded-xl font-semibold text-lg shadow-md hover:bg-cafe-700 transition-all">
                    Masuk
                </button>

                <!-- Google OAuth Button -->
                <div class="mt-4">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">atau</span>
                        </div>
                    </div>
                    
                    <a href="{{ route('auth.google') }}"
                       class="mt-4 w-full flex items-center justify-center px-4 py-3 border border-gray-300 rounded-xl shadow-sm bg-white text-gray-700 hover:bg-gray-50 transition-all">
                        <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        Masuk dengan Google
                    </a>
                </div>

                <p class="mt-4 text-sm text-center text-gray-600">
                    Belum punya akun?
                    <a href="{{ route('membership.register') }}" class="text-cafe-700 font-semibold hover:underline">
                        Daftar Member Sekarang!
                    </a>
                </p>
                
                <p class="mt-2 text-xs text-center text-gray-500">
                    * Membership Rp 100.000/tahun - Dapatkan akses ke promo & voucher eksklusif
                </p>
            </form>

        </div>
    </div>
</div>

</body>
</html>
