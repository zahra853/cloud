<!doctype html>
<html class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership Aktif! - Joglo Lontar Cafe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
</head>

<body class="bg-green-50 min-h-screen flex items-center justify-center">

    <div class="max-w-md mx-auto py-12 px-4">
        <div class="bg-white rounded-2xl shadow-xl p-8 text-center">
            
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-check-circle text-green-500 text-5xl"></i>
            </div>

            <h1 class="text-2xl font-bold text-gray-800 mb-2">Selamat!</h1>
            <p class="text-gray-600 mb-6">Membership Anda telah aktif</p>

            <div class="bg-amber-50 border border-amber-200 rounded-xl p-6 mb-6 text-left">
                <p class="text-gray-600 mb-2"><strong>Member:</strong> {{ Auth::user()->name }}</p>
                <p class="text-gray-600 mb-2"><strong>Email:</strong> {{ Auth::user()->email }}</p>
                <p class="text-gray-600"><strong>Berlaku hingga:</strong> 
                    @if(Auth::user()->membership_expires_at)
                        {{ Auth::user()->membership_expires_at->format('d M Y') }}
                    @else
                        1 Tahun
                    @endif
                </p>
            </div>

            <div class="bg-green-100 rounded-xl p-4 mb-6">
                <p class="text-green-800 font-semibold">Nikmati keuntungan member Anda:</p>
                <p class="text-green-700 text-sm mt-2">Gunakan kode voucher MEMBER10 atau MEMBER20 untuk diskon!</p>
            </div>

            <a href="{{ route('homepage') }}"
               class="block w-full bg-amber-500 text-white py-3 rounded-xl font-semibold shadow-md hover:bg-amber-600 transition-all">
                Mulai Belanja
            </a>

        </div>
    </div>

</body>
</html>
