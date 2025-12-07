<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review - Joglo Lontar Cafe</title>

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

</head>

<body class="min-h-screen bg-cover bg-center"
      style="background-image: url('{{ asset('images/homepage/gambar2.png') }}');">

    {{-- overlay utama --}}
    <div class="min-h-screen bg-black/40 relative">

        {{-- ================= NAVBAR (SAMA PERSIS HOMEPAGE) ================= --}}
        <nav class="absolute top-5 left-1/2 -translate-x-1/2 w-[95%] max-w-6xl
                    bg-white/20 backdrop-blur-xl rounded-full px-8 py-4 flex items-center justify-between shadow-md z-20">

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
                    <a href="{{ route('review') }}" class="text-yellow-300">REVIEW</a>
                    <a href="{{ route('location') }}" class="hover:text-yellow-300">LOCATION</a>
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

        {{-- ================= SECTION REVIEW ================= --}}
        <section class="pt-32 pb-16 px-6 flex justify-center">
            <div class="w-full max-w-6xl text-white">

                {{-- Title --}}
                <h1 class="title-font text-4xl md:text-5xl text-center text-[#FF4A2C] drop-shadow-md mb-10">
                    A Review from our love one
                </h1>

                {{-- GRID 2x2 REVIEW --}}
                <div class="grid md:grid-cols-2 gap-12 text-sm md:text-base">

                    {{-- REVIEW 1 --}}
                    <div>
                        <h2 class="font-bold text-xl">Dhia Adzkia</h2>
                        <p class="font-semibold mt-1">Desember 1, 2025</p>

                        {{-- Stars --}}
                        <div class="mt-3 text-xl text-[#FF5A2C]">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star-half-stroke"></i>
                        </div>

                        <p class="mt-3 text-xs md:text-sm leading-relaxed">
                            Pengalaman ke Joglo Lontar Cafe benar-benar bikin happy. Dari pertama masuk,
                            suasana khas joglo tradisionalnya langsung terasa hangat, adem, dan tenang. Interior kayu
                            dipadu area hijau bikin tempat ini estetik banget, cocok buat santai lama, ngobrol, atau
                            sekalian healing tipis-tipis. Musiknya juga pas, nggak terlalu kenceng, jadi nyaman buat
                            kerja atau baca.
                        </p>
                    </div>

                    {{-- REVIEW 2 --}}
                    <div>
                        <h2 class="font-bold text-xl">Dhini Julia</h2>
                        <p class="font-semibold mt-1">November 25, 2025</p>

                        <div class="mt-3 text-xl text-[#FF5A2C]">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>

                        <p class="mt-3 text-xs md:text-sm leading-relaxed">
                            Kalau cari tempat nongkrong yang nyaman plus makanan enak, Joglo Lontar Cafe ini jawabannya.
                            Makanannya beneran memuaskan—Nasi Goreng Joglo gurihnya pas, aromanya wangi, porsinya juga
                            ngenyangin. Minuman hangatnya juga enak, cocok diminum sore hari sambil menikmati suasana
                            joglo dan gemericik suara air di area outdoor.
                        </p>
                    </div>

                    {{-- REVIEW 3 --}}
                    <div>
                        <h2 class="font-bold text-xl mt-4 md:mt-0">Martasya Ika</h2>
                        <p class="font-semibold mt-1">Agustus 17, 2025</p>

                        <div class="mt-3 text-xl text-[#FF5A2C]">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>

                        <p class="mt-3 text-xs md:text-sm leading-relaxed">
                            Makanannya nggak kalah keren. Nasi Goreng Joglo rasanya gurih mantap dengan bumbu yang
                            meresap, porsinya pas dan bikin kenyang. Ayam katsu crunchy di luar tapi lembut di dalam.
                            Pelayanannya ramah dan gercep, harga masih worth it banget buat kualitas rasa dan tempatnya.
                            Intinya, ini cafe yang komplit; enak buat makan, nyaman buat nongkrong. Wajib coba!
                        </p>
                    </div>

                    {{-- REVIEW 4 --}}
                    <div>
                        <h2 class="font-bold text-xl mt-4 md:mt-0">Zahra’s</h2>
                        <p class="font-semibold mt-1">Maret 3, 2025</p>

                        <div class="mt-3 text-xl text-[#FF5A2C]">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>

                        <p class="mt-3 text-xs md:text-sm leading-relaxed">
                            Suasananya juara. Vibes joglo tradisionalnya kerasa banget: adem, tenang, dan estetik.
                            Banyak spot bagus buat foto atau kerja santai, area hijau bikin betah lama-lama. Pelayanan
                            ramah dan cepat, jadi makin nyaman. Overall, tempat ini worth it banget buat kumpul, nugas,
                            atau sekadar ngopi santai. Pasti balik lagi!
                        </p>
                    </div>

                </div>
            </div>
        </section>

    </div>
</body>
</html>
