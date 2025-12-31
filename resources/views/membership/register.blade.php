<!doctype html>
<html class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Member - Joglo Lontar Cafe</title>
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

        <a href="{{ url('/') }}"
           class="absolute top-6 left-6 text-white text-3xl font-bold z-20">
            &larr;
        </a>

        <div class="absolute inset-0 flex flex-col justify-center pl-16 z-10">
            <h1 class="text-4xl font-bold text-white max-w-md leading-tight">
                Bergabung Menjadi Member
            </h1>
            <p class="text-white mt-4 max-w-sm">
                Nikmati berbagai promo dan voucher eksklusif hanya untuk member!
            </p>
            <div class="mt-6 bg-white/20 backdrop-blur-sm p-4 rounded-lg max-w-sm">
                <p class="text-white font-semibold text-lg">Keuntungan Member:</p>
                <ul class="text-white mt-2 space-y-1 text-sm">
                    <li>✓ Akses voucher eksklusif</li>
                    <li>✓ Diskon khusus member</li>
                    <li>✓ Promo ulang tahun</li>
                    <li>✓ Poin rewards</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- RIGHT SIDE (REGISTER FORM) -->
    <div class="flex items-center justify-center bg-cafe-100 p-8 relative overflow-y-auto">

        <a href="{{ url('/login') }}"
           class="absolute top-6 left-6 text-cafe-700 text-2xl font-bold md:hidden">
            &larr;
        </a>

        <div class="w-full max-w-md bg-white shadow-xl rounded-3xl p-8 border border-cafe-300 my-8">

            <h2 class="text-2xl font-bold text-cafe-700 mb-2 text-center">Daftar Member</h2>
            <p class="text-gray-500 text-sm mb-2 text-center">
                Buat akun dan jadi member sekarang
            </p>
            <p class="text-cafe-500 text-sm mb-6 text-center font-semibold">
                Rp 100.000 / tahun
            </p>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('membership.register.post') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-cafe-500"
                           required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-cafe-500"
                           required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">No. Telepon</label>
                    <input type="tel" name="phone" value="{{ old('phone') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-cafe-500"
                           placeholder="08xxxxxxxxxx"
                           required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Alamat</label>
                    <textarea name="address" rows="2"
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-cafe-500"
                              required>{{ old('address') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Password</label>
                    <input type="password" name="password"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-cafe-500"
                           minlength="8"
                           required>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-cafe-500"
                           required>
                </div>

                <button type="submit"
                        class="w-full bg-cafe-500 text-white py-3 rounded-xl font-semibold text-lg shadow-md hover:bg-cafe-700 transition-all">
                    Daftar & Lanjut Pembayaran
                </button>

                <p class="mt-4 text-sm text-center text-gray-600">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-cafe-700 font-semibold hover:underline">
                        Login
                    </a>
                </p>

                <p class="mt-4 text-xs text-center text-gray-500">
                    Dengan mendaftar, Anda menyetujui syarat & ketentuan yang berlaku
                </p>
            </form>

        </div>
    </div>
</div>

</body>
</html>
