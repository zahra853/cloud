<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Menu - Joglo Lontar Cafe</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Anton&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');

        body {
            font-family: "Montserrat", sans-serif;
        }

        .anton {
            font-family: 'Anton', sans-serif;
        }
        
        .line-clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
        }
    </style>
</head>

<body class="bg-[#C8A892]">

    <!-- ================= NAVBAR ================= -->


    <!-- ================= HERO IMAGE + TITLE ================= -->
    <section class="w-full overflow-hidden">
        <div class="w-full relative rounded-b-[40px] overflow-hidden">
            
        <!-- NAVBAR -->
        <nav class="absolute top-5 left-1/2 -translate-x-1/2 w-[95%] max-w-6xl
                    bg-white/20 backdrop-blur-xl rounded-full px-8 py-4 flex items-center justify-between shadow-md z-20">

            <!-- Logo -->
            <div class="text-[#F58834] font-bold text-sm tracking-wide uppercase">
                JOGLO LONTAR CAFE
            </div>

        <!-- MENU -->
        <div class="flex items-center justify-center flex-1">
            <div class="bg-[#4E2C1C] text-white rounded-full px-10 py-3 flex items-center gap-10 text-sm font-semibold">
                <a href="{{ route('homepage') }}" class="hover:text-yellow-300">HOME</a>
                <a href="{{ url('/') }}#learn" class="hover:text-yellow-300">LEARN</a>
                <a href="{{ url('/') }}#about" class="hover:text-yellow-300">ABOUT US</a>

                <a href="{{ route('review') }}" class="hover:text-yellow-300">REVIEW</a>
                <a href="{{ route('location') }}" class="hover:text-yellow-300">LOCATION</a>

            </div>
        </div>


            <!-- Right Icons -->
            <div class="flex items-center gap-6 text-white text-lg">

                <a href="{{ route('book') }}">
                    <button class="bg-[#7A3E22] px-6 py-2 rounded-full text-white font-semibold flex items-center justify-center">BOOK A TABLE</button>
                </a>

                <i class="fa-solid fa-magnifying-glass hover:text-yellow-300 cursor-pointer"></i>

                <a href="{{ route('login') }}">
                    <i class="fa-regular fa-user hover:text-yellow-300 cursor-pointer"></i>
                </a>
                    <i class="fa-solid fa-bag-shopping hover:text-yellow-300 cursor-pointer"></i>
            </div>
        </nav>

            <img src="{{ asset('images/homepage/gambar2.png') }}"
                 class="w-full h-[500px] object-cover brightness-90">

            <!-- overlay -->
            <div class="absolute inset-0 bg-black/30"></div>

            <!-- teks -->
            <div class="absolute left-1/2 -translate-x-1/2 top-40 text-center w-full px-4">
                <h1 class="anton text-[70px] md:text-[96px] text-[#FF3A20] leading-[0.85] drop-shadow-xl">
                    OUR MENU
                </h1>

                <p class="text-[#F9D9B8] text-base md:text-xl mt-4 tracking-wide">
                    DISCOVER OUR BEST MENU AND START CHOOSING YOUR FAVORITES!
                </p>
            </div>
        </div>
    </section>


    <!-- ================= MENU LIST ================= -->
    <section class="max-w-6xl mx-auto py-14 px-4">

        @php
            $categories = $barangs->groupBy('category');
        @endphp

        @forelse($categories as $category => $products)
            <div class="mb-16">
                <h2 class="text-3xl md:text-4xl font-extrabold text-[#FF3A20] mb-6">
                    {{ $category ?? 'Other' }}
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($products as $barang)
                        <article class="bg-[#D8B89A] rounded-[32px] shadow-lg overflow-hidden flex flex-col hover:shadow-xl transition">
                            @if($barang->image_url)
                                <img src="{{ asset($barang->image_url) }}"
                                     class="w-full h-40 md:h-48 object-cover">
                            @else
                                <div class="w-full h-40 md:h-48 bg-[#C8A892] flex items-center justify-center">
                                    <i class="fas fa-utensils text-4xl text-[#8B7355]"></i>
                                </div>
                            @endif
                            
                            <div class="flex-1 p-5 flex flex-col justify-between">
                                <div>
                                    <h3 class="font-semibold text-lg text-[#3A2A20]">{{ $barang->name }}</h3>
                                    <p class="text-sm text-[#4B3527] mt-2 line-clamp-2">
                                        {{ $barang->description ?? 'Delicious menu item from our kitchen.' }}
                                    </p>
                                </div>
                                <div class="flex items-center justify-between mt-4">
                                    <div>
                                        @if($barang->discount > 0)
                                            <span class="text-sm text-gray-500 line-through">
                                                Rp {{ number_format($barang->price, 0, ',', '.') }}
                                            </span>
                                            <span class="font-bold text-[#FF3A20]">
                                                Rp {{ number_format($barang->final_price, 0, ',', '.') }}
                                            </span>
                                        @else
                                            <span class="font-bold text-[#3A2A20]">
                                                Rp {{ number_format($barang->price, 0, ',', '.') }}
                                            </span>
                                        @endif
                                    </div>
                                    
                                    @auth
                                        <form action="{{ route('user.cart.add', $barang) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="w-10 h-10 rounded-full bg-[#7A3E22] text-white flex items-center justify-center text-lg hover:bg-[#5C2E1A] transition"
                                                title="Add to Cart">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}"
                                            class="w-10 h-10 rounded-full bg-[#7A3E22] text-white flex items-center justify-center text-lg hover:bg-[#5C2E1A] transition"
                                            title="Login to Order">
                                            <i class="fas fa-plus"></i>
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="text-center py-16">
                <i class="fas fa-coffee text-6xl text-[#8B7355] mb-4"></i>
                <p class="text-xl text-[#5C4033]">Menu is being prepared...</p>
            </div>
        @endforelse

    </section>

    <!-- ================= FOOTER ================= -->
    <footer class="bg-[#3E2C25] text-white py-10 px-8 ">
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-10">
            <div>
                <h3 class="font-bold text-lg mb-3">Joglo Lontar Café</h3>
                <p class="text-sm">
                    The best Indonesian traditional café with Joglo concept.
                </p>
            </div>
            <div>
                <h3 class="font-bold mb-3">Opening Hours</h3>
                <p class="text-sm">Mon – Fri : 10.00 – 22.00</p>
                <p class="text-sm">Sat – Sun : 08.00 – 23.00</p>
            </div>
            <div>
                <h3 class="font-bold mb-3">Contact Us</h3>
                <p class="text-sm">joglolontar@gmail.com</p>
                <p class="text-sm">+62 812-3456-789</p>
            </div>
            <div>
                <h3 class="font-bold mb-3">Follow Us</h3>
                <p class="text-sm">@joglolontarcafe</p>
            </div>
        </div>
        <p class="text-center mt-10 text-xs text-gray-300">
            © 2025 Joglo Lontar Café. All Rights Reserved.
        </p>
    </footer>

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#7A3E22',
        });
    </script>
    @endif

</body>
</html>
