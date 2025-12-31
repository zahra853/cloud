{{-- Navbar khusus untuk halaman membership dengan desain JOGLO LONTAR --}}
<nav class="fixed top-0 left-0 right-0 z-50 bg-gradient-to-b from-[#3A2A20]/95 to-[#5C4033]/90 backdrop-blur-sm border-b-2 border-[#B8860B]">
    <div class="max-w-screen-xl mx-auto">
        {{-- Top Bar --}}
        <div class="flex justify-end px-4 py-1 text-xs text-gray-400 border-b border-[#5C4033]">
            <a href="#" class="hover:text-white flex items-center gap-1">
                <span>Membership Portal</span>
                <i class="fab fa-instagram text-[#DAA520]"></i>
            </a>
        </div>
        
        {{-- Main Navbar --}}
        <div class="flex items-center justify-between px-4 py-3">
            {{-- Logo --}}
            <a href="/" class="flex items-center gap-3">
                <div class="w-14 h-14 border-2 border-[#DAA520] rounded-lg flex items-center justify-center bg-[#3A2A20] p-1">
                    <div class="text-center">
                        <i class="fas fa-leaf text-[#DAA520] text-lg"></i>
                        <p class="text-[#DAA520] text-[6px] font-bold leading-none mt-0.5">JOGLO LONTAR</p>
                        <p class="text-[#B8860B] text-[4px] tracking-widest">MEMBERSHIP</p>
                    </div>
                </div>
            </a>

            {{-- Navigation Menu (Desktop) --}}
            <div class="hidden md:flex items-center gap-8">
                <a href="/" class="text-white hover:text-[#DAA520] font-medium tracking-wide transition">
                    BERANDA
                </a>
                <a href="/menu" class="text-white hover:text-[#DAA520] font-medium tracking-wide transition">
                    MENU
                </a>
                <a href="/reservasi" class="text-white hover:text-[#DAA520] font-medium tracking-wide transition">
                    RESERVASI
                </a>
                <a href="/galeri" class="text-white hover:text-[#DAA520] font-medium tracking-wide transition">
                    GALERI
                </a>
                <a href="{{ route('membership.landing') }}" class="text-[#DAA520] font-bold tracking-wide transition border-b-2 border-[#DAA520] pb-1">
                    MEMBERSHIP
                </a>
            </div>

            {{-- Right Side (Auth) --}}
            <div class="flex items-center gap-4">
                @auth
                    {{-- Profile Dropdown --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="flex items-center gap-2 text-white hover:text-[#DAA520] transition">
                            <img class="w-9 h-9 rounded-full border-2 border-[#DAA520]" 
                                 src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=B8860B&color=fff" 
                                 alt="{{ Auth::user()->name }}">
                            <span class="hidden md:inline text-sm font-medium">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        
                        {{-- Dropdown Menu --}}
                        <div x-show="open" 
                             @click.outside="open = false"
                             class="absolute right-0 mt-2 w-48 bg-[#3A2A20] border border-[#5C4033] rounded-lg shadow-xl overflow-hidden">
                            <div class="px-4 py-3 border-b border-[#5C4033]">
                                <p class="text-sm font-semibold text-white">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
                                @if(Auth::user()->isActiveMember())
                                    <span class="inline-block mt-1 text-xs bg-[#DAA520] text-[#3A2A20] px-2 py-0.5 rounded font-bold">MEMBER AKTIF</span>
                                @endif
                            </div>
                            <ul class="py-2 text-sm text-gray-300">
                                @if(Auth::user()->role == 'admin')
                                    <li>
                                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 hover:bg-[#5C4033] hover:text-[#DAA520]">
                                            <i class="fas fa-tachometer-alt mr-2"></i> Admin Dashboard
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <a href="{{ route('user.profile') }}" class="block px-4 py-2 hover:bg-[#5C4033] hover:text-[#DAA520]">
                                        <i class="fas fa-user mr-2"></i> Profil Saya
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('user.dashboard.membership') }}" class="block px-4 py-2 hover:bg-[#5C4033] hover:text-[#DAA520]">
                                        <i class="fas fa-crown mr-2"></i> Dashboard Member
                                    </a>
                                </li>
                                <li class="border-t border-[#5C4033]">
                                    <form action="{{ route('logout') }}" method="POST" class="block">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 hover:bg-[#5C4033] text-red-400 hover:text-red-300">
                                            <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" 
                       class="px-5 py-2 bg-gradient-to-r from-[#B8860B] to-[#DAA520] text-[#3A2A20] rounded-full font-bold text-sm hover:shadow-lg hover:scale-105 transition-all duration-300">
                        MASUK
                    </a>
                @endauth

                {{-- Mobile Menu Button --}}
                <button type="button" 
                        class="md:hidden p-2 text-white hover:text-[#DAA520]"
                        onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="hidden md:hidden border-t border-[#5C4033]">
            <ul class="py-4 px-4 space-y-3 text-white">
                <li>
                    <a href="/" class="block py-2 hover:text-[#DAA520]">BERANDA</a>
                </li>
                <li>
                    <a href="/menu" class="block py-2 hover:text-[#DAA520]">MENU</a>
                </li>
                <li>
                    <a href="/reservasi" class="block py-2 hover:text-[#DAA520]">RESERVASI</a>
                </li>
                <li>
                    <a href="/galeri" class="block py-2 hover:text-[#DAA520]">GALERI</a>
                </li>
                <li>
                    <a href="{{ route('membership.landing') }}" class="block py-2 text-[#DAA520] font-bold">MEMBERSHIP</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
