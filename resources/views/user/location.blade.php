<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Location - Joglo Lontar Cafe</title>

    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap');

        * {
            font-family: "Montserrat", sans-serif;
        }

        .title-font {
            font-family: "Fredoka One", cursive;
        }
    </style>

    {{-- Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cafe: {
                            50: '#F4F0EA',
                            100: '#E8D5C4',
                            300: '#C8A888',
                            500: '#A66A41',
                            700: '#6B3F25'
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="min-h-screen bg-cover bg-center"
      style="background-image: url('{{ asset('images/homepage/gambar2.png') }}');">

    {{-- overlay + parent absolute --}}
    <div class="min-h-screen bg-black/40 relative">

        {{-- NAVBAR – SAMA PERSIS KAYAK HOMEPAGE --}}
        <nav class="absolute top-5 left-1/2 -translate-x-1/2 w-[95%] max-w-6xl
                    bg-white/20 backdrop-blur-xl rounded-full px-8 py-4
                    flex items-center justify-between shadow-md z-20">

            {{-- Logo --}}
            <div class="text-[#F58834] font-bold text-sm tracking-wide uppercase">
                JOGLO LONTAR CAFE
            </div>

            {{-- MENU --}}
            <div class="flex items-center justify-center flex-1">
                <div class="bg-[#4E2C1C] text-white rounded-full px-10 py-3 flex items-center gap-10 text-sm font-semibold">
                    <a href="{{ url('/') }}" class="hover:text-yellow-300">HOME</a>
                    <a href="{{ url('/#learn') }}" class="hover:text-yellow-300">LEARN</a>
                    <a href="{{ url('/#about') }}" class="hover:text-yellow-300">ABOUT US</a>
                    <a href="{{ route('location') }}" class="text-yellow-300">LOCATION</a>
                    <a href="{{ url('/#review') }}" class="hover:text-yellow-300">REVIEW</a>
                </div>
            </div>

            {{-- Right Icons --}}
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


        {{-- TITLE + MAP --}}
        <section class="pt-28 px-4 flex justify-center">
            <div class="w-full max-w-6xl">

                <div class="mb-4">
                    <h1 class="title-font text-4xl md:text-5xl text-[#F58834] drop-shadow-md">
                        Our Location
                    </h1>
                    <p class="text-white mt-2 text-base md:text-lg">
                        Find and visit Joglo Lontar Cafe
                    </p>
                </div>

                {{-- MAP CARD --}}
                <div class="mt-4 bg-white rounded-[32px] shadow-2xl overflow-hidden">
                    <div class="w-full h-[260px] md:h-[320px]">
                        {{-- GANTI SRC DENGAN EMBED MAP ASLI JOGLO LONTAR --}}
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.08394494651!2d112.6800!3d-7.5590!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0:0x0!2sJoglo%20Lontar%20Cafe!5e0!3m2!1sen!2sid!4v1700000000000"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>

            </div>
        </section>

        {{-- CONTENT --}}
        <section class="pb-16 px-4 flex justify-center">
            <div class="w-full max-w-6xl">

                {{-- CONTACT + HOW TO GET HERE --}}
                <div class="grid md:grid-cols-2 gap-8 mt-16">

                    {{-- CONTACT CARD --}}
                    <div class="bg-[#C8A892] bg-opacity-90 rounded-[32px] px-8 py-8 shadow-xl">
                        <h2 class="text-2xl font-bold mb-6 text-[#3A2A20]">Contact</h2>

                        <div class="space-y-6 text-sm md:text-base">
                            {{-- Address --}}
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-10 h-10 rounded-xl bg-white flex items-center justify-center shadow-md shrink-0">
                                    <i class="fa-solid fa-location-dot text-orange-500"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-[#3A2A20]">Address</p>
                                    <p class="text-xs md:text-sm text-[#3A2A20]">
                                        Jl. Raya Lontar No.403, Surabaya, East Java
                                    </p>
                                </div>
                            </div>

                            {{-- Telephone --}}
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-10 h-10 rounded-xl bg-white flex items-center justify-center shadow-md shrink-0">
                                    <i class="fa-solid fa-phone text-orange-500"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-[#3A2A20]">Telephone</p>
                                    <p class="text-xs md:text-sm text-[#3A2A20]">
                                        +62 812-3453-6468
                                    </p>
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-10 h-10 rounded-xl bg-white flex items-center justify-center shadow-md shrink-0">
                                    <i class="fa-solid fa-envelope text-orange-500"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-[#3A2A20]">E-mail</p>
                                    <p class="text-xs md:text-sm text-[#3A2A20]">
                                        joglolontarcafe@gmail.com
                                    </p>
                                </div>
                            </div>

                            {{-- Opening Hours --}}
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-10 h-10 rounded-xl bg-white flex items-center justify-center shadow-md shrink-0">
                                    <i class="fa-regular fa-clock text-orange-500"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-[#3A2A20]">Opening Hours</p>
                                    <p class="text-xs md:text-sm text-[#3A2A20]">
                                        Open Daily, 10:00 AM – 22:00 PM
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- HOW TO GET HERE CARD --}}
                    <div class="bg-[#C8A892] bg-opacity-90 rounded-[32px] px-8 py-8 shadow-xl">
                        <h2 class="text-2xl font-bold mb-6 text-[#3A2A20]">How to get here</h2>

                        <div class="space-y-5 text-sm md:text-base text-[#3A2A20]">

                            {{-- By Car --}}
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-10 h-10 rounded-xl bg-white flex items-center justify-center shadow-md shrink-0">
                                    <i class="fa-solid fa-car-side text-orange-500"></i>
                                </div>
                                <div>
                                    <p class="font-semibold mb-1">By Car</p>
                                    <ul class="list-disc list-inside text-xs md:text-sm">
                                        <li>Located on Jl. Raya Lontar No.403, Lontar area, Sambikerep District.</li>
                                        <li>Easy access from West Surabaya main roads.</li>
                                        <li>Spacious parking available for cars and motorbikes.</li>
                                    </ul>
                                </div>
                            </div>

                            {{-- By Public Transportation --}}
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-10 h-10 rounded-xl bg-white flex items-center justify-center shadow-md shrink-0">
                                    <i class="fa-solid fa-bus text-orange-500"></i>
                                </div>
                                <div>
                                    <p class="font-semibold mb-1">By Public Transportation</p>
                                    <ul class="list-disc list-inside text-xs md:text-sm">
                                        <li>Online ride-hailing (Grab/Gojek) available to Joglo Lontar Cafe.</li>
                                        <li>Angkot/feeder routes to Sambikerep–Lontar area are available nearby.</li>
                                        <li>Continue a short walk or ride to Jl. Raya Lontar No.403.</li>
                                    </ul>
                                </div>
                            </div>

                            {{-- Landmark --}}
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-10 h-10 rounded-xl bg-white flex items-center justify-center shadow-md shrink-0">
                                    <i class="fa-solid fa-landmark text-orange-500"></i>
                                </div>
                                <div>
                                    <p class="font-semibold mb-1">Landmark</p>
                                    <ul class="list-disc list-inside text-xs md:text-sm">
                                        <li>Near Universitas Negeri Surabaya (Unesa) Kampus Lidah Wetan.</li>
                                        <li>In the Lontar–Sambikerep neighborhood, West Surabaya.</li>
                                        <li>Look for our location along Jl. Raya Lontar, number 403.</li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                {{-- BOTTOM BUTTONS --}}
                <div class="grid md:grid-cols-3 gap-6 mt-10">

                    {{-- Google Maps --}}
                    <a href="https://maps.app.goo.gl/" target="_blank"
                        class="bg-[#C8A892] bg-opacity-90 rounded-[24px] px-6 py-4 flex flex-col items-center justify-center shadow-xl hover:bg-[#b89478] transition">
                        <i class="fa-solid fa-map-location-dot text-2xl mb-2 text-orange-500"></i>
                        <span class="font-semibold text-sm md:text-base text-[#3A2A20]">Google Maps</span>
                    </a>

                    {{-- Contact Admin (WhatsApp) --}}
                    <a href="https://wa.me/6281234536468" target="_blank"
                        class="bg-[#C8A892] bg-opacity-90 rounded-[24px] px-6 py-4 flex flex-col items-center justify-center shadow-xl hover:bg-[#b89478] transition">
                        <i class="fa-solid fa-phone-volume text-2xl mb-2 text-orange-500"></i>
                        <span class="font-semibold text-sm md:text-base text-[#3A2A20]">Contact Admin</span>
                    </a>

                    {{-- Send Email --}}
                    <a href="mailto:joglolontarcafe@gmail.com"
                        class="bg-[#C8A892] bg-opacity-90 rounded-[24px] px-6 py-4 flex flex-col items-center justify-center shadow-xl hover:bg-[#b89478] transition">
                        <i class="fa-solid fa-envelope-open-text text-2xl mb-2 text-orange-500"></i>
                        <span class="font-semibold text-sm md:text-base text-[#3A2A20]">Send Email</span>
                    </a>

                </div>
            </div>
        </section>

    </div>
</body>

</html>
