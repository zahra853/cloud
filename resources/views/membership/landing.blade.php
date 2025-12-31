<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Membership - Joglo Lontar Cafe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap');
        body { font-family: 'Poppins', sans-serif; }
        .font-display { font-family: 'Playfair Display', serif; }
        .wood-bg {
            background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)),
                        url('/images/homepage/gambar2.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .gold-gradient {
            background: linear-gradient(135deg, #B8860B 0%, #DAA520 50%, #B8860B 100%);
        }
        .card-pattern {
            background: linear-gradient(to bottom, rgba(92, 64, 51, 0.95), rgba(58, 42, 32, 0.98)),
                        url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80"><path fill="%237A3E22" opacity="0.1" d="M0 0h80v80H0z M10 10h20v20H10z M50 50h20v20H50z"/></svg>');
        }
    </style>
</head>
<body class="wood-bg min-h-screen">
    <!-- Alpine.js for dropdown -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Navbar JOGLO LONTAR -->
    @include('membership.partials.navbar')

    <!-- Main Content -->
    <main class="pt-24 pb-16 px-4" style="padding-top: 200px;">
        <div class="max-w-4xl mx-auto">
            
            <!-- Success Alert -->
            @if(session('success'))
            <div class="bg-green-500/90 backdrop-blur border border-green-400 text-white px-6 py-4 rounded-lg mb-8 text-center" role="alert">
                <div class="flex items-center justify-center">
                    <i class="fas fa-check-circle mr-3 text-xl"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
                @auth
                <div class="mt-4">
                    <a href="{{ route('user.dashboard.membership') }}" 
                       class="inline-flex items-center gap-2 px-6 py-2 bg-white text-green-600 font-bold rounded-full hover:bg-gray-100 transition">
                        <i class="fas fa-tachometer-alt"></i>
                        Go to Dashboard
                    </a>
                </div>
                @endauth
            </div>
            @endif
            
            <!-- Membership Card -->
            <div class="card-pattern rounded-3xl p-10 shadow-2xl border-2 border-[#B8860B]/30">
                
                <!-- Header -->
                <div class="text-center mb-10">
                    <h1 class="font-display text-4xl md:text-5xl font-bold text-[#DAA520] mb-2">
                        JOGLO LONTAR
                    </h1>
                    <h2 class="font-display text-3xl md:text-4xl font-bold text-white mb-6">
                        PREMIUM MEMBERSHIP
                    </h2>
                    <p class="text-[#DAA520] text-lg tracking-wider">
                        AKTIFKAN SEKARANG, NIKMATI KEUNTUNGAN EKSKLUSIF!
                    </p>
                </div>

                <!-- Benefits Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                    <!-- Benefit 1 -->
                    <div class="bg-[#5C4033]/50 rounded-2xl p-6 text-center border border-[#B8860B]/30">
                        <div class="w-16 h-16 mx-auto mb-4 gold-gradient rounded-full flex items-center justify-center">
                            <i class="fas fa-wallet text-2xl text-[#3A2A20]"></i>
                        </div>
                        <h3 class="text-[#DAA520] font-bold text-lg mb-2">BAYAR SEKALI,<br>UNTUNG BERKALI</h3>
                        <p class="text-gray-300 text-sm">
                            Pembayaran keanggotaan hanya di awal pendaftaran. Keanggotaan aktif selamanya!
                        </p>
                    </div>

                    <!-- Benefit 2 -->
                    <div class="bg-[#5C4033]/50 rounded-2xl p-6 text-center border border-[#B8860B]/30">
                        <div class="w-16 h-16 mx-auto mb-4 gold-gradient rounded-full flex items-center justify-center">
                            <i class="fas fa-percent text-2xl text-[#3A2A20]"></i>
                        </div>
                        <h3 class="text-[#DAA520] font-bold text-lg mb-2">DISKON & PROMO<br>MELIMPAH</h3>
                        <p class="text-gray-300 text-sm">
                            Dapatkan potongan harga spesial untuk semua menu dan penawaran eksklusif setiap saat.
                        </p>
                    </div>

                    <!-- Benefit 3 -->
                    <div class="bg-[#5C4033]/50 rounded-2xl p-6 text-center border border-[#B8860B]/30">
                        <div class="w-16 h-16 mx-auto mb-4 gold-gradient rounded-full flex items-center justify-center">
                            <i class="fas fa-coins text-2xl text-[#3A2A20]"></i>
                        </div>
                        <h3 class="text-[#DAA520] font-bold text-lg mb-2">KUMPULKAN POIN,<br>TUKAR MENU FAVORIT!</h3>
                        <p class="text-gray-300 text-sm">
                            Setiap pembelian dapat mengumpulkan poin yang dapat ditukarkan dengan pilihan menu istimewa!
                        </p>
                    </div>
                </div>

                <!-- CTA Button -->
                <div class="text-center">
                    @auth
                        <a href="{{ route('user.dashboard.membership') }}" 
                           class="inline-flex items-center gap-3 px-10 py-4 gold-gradient text-[#3A2A20] font-bold text-lg rounded-full hover:shadow-lg hover:scale-105 transition-all duration-300">
                            AKTIVASI MEMBERSHIP
                            <i class="fas fa-crown"></i>
                        </a>
                        <p class="mt-4 text-gray-400 text-sm">
                            Pilih paket membership yang sesuai dengan kebutuhan Anda
                        </p>
                    @else
                        <a href="{{ route('register') }}" 
                           class="inline-flex items-center gap-3 px-10 py-4 gold-gradient text-[#3A2A20] font-bold text-lg rounded-full hover:shadow-lg hover:scale-105 transition-all duration-300">
                            DAFTAR SEKARANG
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        <p class="mt-4 text-gray-400 text-sm">
                            Syarat & Ketentuan Berlaku
                        </p>
                    @endauth
                </div>
            </div>

            <!-- Additional Info -->
            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Membership Tiers Preview -->
                @auth
                <a href="{{ route('user.dashboard.membership') }}" class="bg-white/10 backdrop-blur rounded-xl p-6 text-center hover:bg-white/20 transition cursor-pointer">
                    <i class="fas fa-medal text-3xl text-gray-400 mb-3"></i>
                    <h4 class="text-white font-bold">Basic</h4>
                    <p class="text-[#DAA520] font-bold text-xl mt-2">Rp 50.000</p>
                    <p class="text-gray-400 text-sm">/ 1 Bulan</p>
                    <div class="mt-3">
                        <span class="text-xs text-[#DAA520]">Klik untuk pilih</span>
                    </div>
                </a>
                <a href="{{ route('user.dashboard.membership') }}" class="bg-[#B8860B]/20 backdrop-blur rounded-xl p-6 text-center border-2 border-[#DAA520] hover:bg-[#B8860B]/30 transition cursor-pointer">
                    <i class="fas fa-crown text-3xl text-[#DAA520] mb-3"></i>
                    <h4 class="text-[#DAA520] font-bold">Premium</h4>
                    <p class="text-white font-bold text-xl mt-2">Rp 100.000</p>
                    <p class="text-gray-300 text-sm">/ 3 Bulan</p>
                    <span class="inline-block mt-2 px-3 py-1 bg-[#DAA520] text-[#3A2A20] text-xs font-bold rounded-full">POPULER</span>
                    <div class="mt-2">
                        <span class="text-xs text-[#DAA520]">Klik untuk pilih</span>
                    </div>
                </a>
                <a href="{{ route('user.dashboard.membership') }}" class="bg-white/10 backdrop-blur rounded-xl p-6 text-center hover:bg-white/20 transition cursor-pointer">
                    <i class="fas fa-gem text-3xl text-purple-400 mb-3"></i>
                    <h4 class="text-white font-bold">VIP</h4>
                    <p class="text-[#DAA520] font-bold text-xl mt-2">Rp 250.000</p>
                    <p class="text-gray-400 text-sm">/ 1 Tahun</p>
                    <div class="mt-3">
                        <span class="text-xs text-[#DAA520]">Klik untuk pilih</span>
                    </div>
                </a>
                @else
                <div class="bg-white/10 backdrop-blur rounded-xl p-6 text-center">
                    <i class="fas fa-medal text-3xl text-gray-400 mb-3"></i>
                    <h4 class="text-white font-bold">Basic</h4>
                    <p class="text-[#DAA520] font-bold text-xl mt-2">Rp 50.000</p>
                    <p class="text-gray-400 text-sm">/ 1 Bulan</p>
                </div>
                <div class="bg-[#B8860B]/20 backdrop-blur rounded-xl p-6 text-center border-2 border-[#DAA520]">
                    <i class="fas fa-crown text-3xl text-[#DAA520] mb-3"></i>
                    <h4 class="text-[#DAA520] font-bold">Premium</h4>
                    <p class="text-white font-bold text-xl mt-2">Rp 100.000</p>
                    <p class="text-gray-300 text-sm">/ 3 Bulan</p>
                    <span class="inline-block mt-2 px-3 py-1 bg-[#DAA520] text-[#3A2A20] text-xs font-bold rounded-full">POPULER</span>
                </div>
                <div class="bg-white/10 backdrop-blur rounded-xl p-6 text-center">
                    <i class="fas fa-gem text-3xl text-purple-400 mb-3"></i>
                    <h4 class="text-white font-bold">VIP</h4>
                    <p class="text-[#DAA520] font-bold text-xl mt-2">Rp 250.000</p>
                    <p class="text-gray-400 text-sm">/ 1 Tahun</p>
                </div>
                @endauth
            </div>

            <!-- Why Join Section -->
            <div class="mt-12 text-center">
                <h3 class="text-white text-2xl font-bold mb-8">Mengapa Bergabung?</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-white/5 rounded-lg p-4">
                        <i class="fas fa-tags text-[#DAA520] text-2xl mb-2"></i>
                        <p class="text-white text-sm">Diskon hingga 15%</p>
                    </div>
                    <div class="bg-white/5 rounded-lg p-4">
                        <i class="fas fa-star text-[#DAA520] text-2xl mb-2"></i>
                        <p class="text-white text-sm">Priority Booking</p>
                    </div>
                    <div class="bg-white/5 rounded-lg p-4">
                        <i class="fas fa-birthday-cake text-[#DAA520] text-2xl mb-2"></i>
                        <p class="text-white text-sm">Birthday Treat</p>
                    </div>
                    <div class="bg-white/5 rounded-lg p-4">
                        <i class="fas fa-gift text-[#DAA520] text-2xl mb-2"></i>
                        <p class="text-white text-sm">Exclusive Events</p>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-[#3A2A20] border-t border-[#5C4033] py-8">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex flex-wrap justify-between items-center gap-6">
                <div class="text-white">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fab fa-facebook-f"></i>
                        <span class="text-sm">Joglo Lontar Membership</span>
                    </div>
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fab fa-instagram"></i>
                        <span class="text-sm">@joglolontar</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-phone"></i>
                        <span class="text-sm">(0353) 2928-9009</span>
                    </div>
                </div>
                <div class="flex items-center gap-6 text-gray-400">
                    <a href="#" class="hover:text-white">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-white">FAQ</a>
                    <div class="flex gap-3">
                        <a href="#" class="w-8 h-8 bg-white/10 rounded-full flex items-center justify-center hover:bg-[#DAA520] hover:text-[#3A2A20] transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-8 h-8 bg-white/10 rounded-full flex items-center justify-center hover:bg-[#DAA520] hover:text-[#3A2A20] transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-8 h-8 bg-white/10 rounded-full flex items-center justify-center hover:bg-[#DAA520] hover:text-[#3A2A20] transition">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="w-8 h-8 bg-white/10 rounded-full flex items-center justify-center hover:bg-[#DAA520] hover:text-[#3A2A20] transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
