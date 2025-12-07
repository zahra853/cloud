<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joglo Lontar Cafe</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');
        * { font-family: "Montserrat", sans-serif; }
    </style>

    <!-- Icons -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
</head>

<body class="bg-[#EDE0D4]">

    <!-- ================= HEADER ================= -->
        <header class="relative w-full h-screen bg-cover bg-center overflow-hidden"
                style="background-image: url('{{ asset('images/homepage/gambar1.png') }}');">


        <div class="absolute inset-0 bg-black/40"></div>

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
                <a href="/" class="hover:text-yellow-300">HOME</a>
                <a href="#learn" class="hover:text-yellow-300">LEARN</a>
                <a href="#about" class="hover:text-yellow-300">ABOUT US</a>

                <!-- UBAH INI -->

                <a href="{{ route('review') }}" class="hover:text-yellow-300">REVIEW</a>
                <a href="{{ route('location') }}" class="hover:text-yellow-300">LOCATION</a>

            </div>
        </div>


            <!-- Right Icons -->
            <div class="flex items-center gap-6 text-white text-lg">

                <a href="{{ route('book') }}">
                    <button class="bg-[#7A3E22] px-6 py-2 rounded-full text-white font-semibold">BOOK A TABLE</button>
                </a>

                <i class="fa-solid fa-magnifying-glass hover:text-yellow-300 cursor-pointer"></i>

                <a href="{{ route('login') }}">
                    <i class="fa-regular fa-user hover:text-yellow-300 cursor-pointer"></i>
                </a>
                    <i class="fa-solid fa-bag-shopping hover:text-yellow-300 cursor-pointer"></i>
            </div>
        </nav>

        <!-- HERO TEXT -->
        <div class="absolute inset-0 flex items-center pl-12 max-w-xl text-white z-20">

            <div>
                <h1 class="text-3xl md:text-4xl font-bold leading-snug mb-3">
                    Joglo Concept and Indonesian Heritage
                </h1>

                <p class="text-sm md:text-base leading-relaxed">
                    Traditional Joglo, delicious food, every day.<br>
                    A great place for new friendships.<br>
                    Get a complimentary traditional snack when your transaction reaches IDR 25k.
                </p>

                <a href="{{ route('menu') }}">
                    <button
                        class="mt-6 bg-[#7A3E22] hover:bg-[#9c5a33]
                                text-sm md:text-base font-semibold
                                px-8 py-3 shadow-lg">
                        OUR MENU
                    </button>
                </a>
            </div>

        </div>


    </header>


    <!-- ================= OUR STORY ================= -->
    <section id="about" class="bg-[#C19D7F] py-20 px-4">

        <!-- TITLE -->
        <h2 class="text-center text-4xl font-semibold tracking-[0.3em] text-[#2E1E17] mb-10"
            style="font-family: 'Poppins', sans-serif;">
            OUR STORY
        </h2>

        <!-- CONTENT BOX -->
        <div class="max-w-5xl mx-auto bg-[#6B4333] text-center px-10 py-14
                    rounded-[40px] shadow-md">

            <p class="text-lg md:text-xl font-semibold leading-relaxed text-[#1A0E0A]"
               style="font-family: 'Poppins', sans-serif;">
                Joglo Lontar Café blends culture, flavor, and comfort in one place.
                Embracing Indonesian heritage, we offer a warm ambiance and signature dishes
                crafted with a modern touch. This café is designed as a gathering place
                for families, friends, and anyone seeking a peaceful moment away from the
                busyness of daily life.
            </p>
        </div>

    </section>

    <!-- ================= BEST MENU ================= -->
    <section class="relative py-20 bg-cover bg-center"
             style="background-image: url('{{ asset('images/homepage/gambar2.png') }}');">

        <!-- DARK OVERLAY BIAR TEKS KEBACA -->
        <div class="absolute inset-0 bg-black/40"></div>

        <div class="relative z-10">

            <h2 class="text-center text-2xl font-bold tracking-wide text-white drop-shadow-lg">
                JOGLO IS BEST MENU FOR YEARS
            </h2>

            <div class="mt-10 max-w-5xl mx-auto grid grid-cols-1 sm:grid-cols-2 gap-12">

                <div class="flex flex-col items-center">
                    <img src="{{ asset('images/homepage/nasigoreng.jpg') }}"
                         class="w-72 h-52 object-cover rounded-md shadow-xl">
                    <p class="mt-4 font-semibold text-white drop-shadow-md">
                        Nasi Goreng Joglo + Telur — 25k
                    </p>
                </div>

                <div class="flex flex-col items-center">
                    <img src="{{ asset('images/homepage/wedanguwuh.jpg') }}"
                         class="w-72 h-52 object-cover rounded-md shadow-xl">
                    <p class="mt-4 font-semibold text-white drop-shadow-md">
                        Wedang Uwuh — 10k
                    </p>
                </div>

            </div>

        <div class="text-center mt-10">
            <a href="{{ route('menu') }}">
                <button
                    class="bg-[#7A3E22] px-6 py-2 rounded-lg text-white font-semibold hover:bg-[#9c5a33] transition">
                    View More
                </button>
            </a>
        </div>


        </div>

    </section>

    <!-- ================= FOOTER ================= -->
    <footer class="bg-[#3E2C25] text-white py-10 px-8 ">
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-10">

            <div>
                <h3 class="font-bold text-lg mb-3">Joglo Lontar Café</h3>
                <p class="text-sm">
                    The best Indonesian traditional café with Joglo concept, serving warm meals and heritage vibes.
                </p>
            </div>

            <div id="location">
                <h3 class="font-bold mb-3">Opening Hours</h3>
                <p class="text-sm">Mon – Fri : 10.00 – 22.00</p>
                <p class="text-sm">Sat – Sun : 08.00 – 23.00</p>
            </div>

            <div>
                <h3 class="font-bold mb-3">Contact Us</h3>
                <p class="text-sm">joglolontar@gmail.com</p>
                <p class="text-sm">+62 812-3456-789</p>
            </div>

            <div id="review">
                <h3 class="font-bold mb-3">Follow Us</h3>
                <p class="text-sm">@joglolontarcafe</p>
                <p class="text-sm">Instagram • TikTok • Facebook</p>
            </div>

        </div>

        <p class="text-center mt-10 text-xs text-gray-300">
            © 2025 Joglo Lontar Café. All Rights Reserved.
        </p>
    </footer>

</body>
</html>
