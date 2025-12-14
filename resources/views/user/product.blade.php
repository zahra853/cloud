<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Menu - Joglo Lontar Cafe</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Anton&display=swap');

        .anton {
            font-family: 'Anton', sans-serif;
        }
    </style>
</head>

<body class="bg-[#C8A892]">

    <!-- ================= NAVBAR ================= -->
    <header class="w-full bg-[#3A2A20] py-5 px-8 flex items-center justify-between">

        <!-- LOGO -->
        <div class="text-[#FFA34C] font-bold text-xl tracking-wide">
            JOGLO LONTAR CAFE
        </div>

        <!-- RIGHT SIDE -->
        <div class="flex items-center gap-6">
            <button class="bg-[#582E1A] hover:bg-[#744027] text-white px-6 py-2 rounded-full text-sm font-semibold">
                ORDER NOW
            </button>

            <i class="fa-solid fa-bag-shopping text-white text-2xl cursor-pointer"></i>
        </div>
    </header>


    <!-- ================= HERO IMAGE + TITLE ================= -->
    <section class="w-full overflow-hidden">
        <div class="w-full relative rounded-b-[40px] overflow-hidden">

            <img src="{{ asset('images/homepage/gambar2.png') }}"
                 class="w-full h-[260px] object-cover brightness-90">

            <!-- overlay -->
            <div class="absolute inset-0 bg-black/30"></div>

            <!-- teks -->
            <div class="absolute left-8 top-10">
                <h1 class="anton text-[96px] md:text-[110px] text-[#FF3A20] leading-[0.85] drop-shadow-xl">
                    OUR MENU
                </h1>

                <p class="text-[#F9D9B8] text-base md:text-xl mt-4 tracking-wide">
                    DISCOVER OUR BEST MENU AND START CHOOSING YOUR FAVORITES!
                </p>
            </div>
        </div>
    </section>


    <!-- ================= MENU LIST ================= -->
    <section class="max-w-6xl mx-auto py-14 space-y-16">

        <!-- ====== KOPI ====== -->
        <div>
            <h2 class="text-3xl md:text-4xl font-extrabold text-[#FF3A20] mb-6">Kopi</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <!-- Americano -->
                <article class="bg-[#D8B89A] rounded-[32px] shadow-lg overflow-hidden flex flex-col">
                    <img src="{{ asset('images/menu/americano.jpg') }}"
                         class="w-full h-40 md:h-52 object-cover">
                    <div class="flex-1 p-5 flex flex-col justify-between">
                        <div>
                            <h3 class="font-semibold text-lg text-[#3A2A20]">Americano</h3>
                            <p class="text-sm text-[#4B3527] mt-2">
                                Espresso dengan tambahan air panas, rasa kopi kuat dan clean.
                            </p>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <span class="font-bold text-[#3A2A20]">12k</span>
                            <button
                                class="w-8 h-8 rounded-full bg-[#7A3E22] text-white flex items-center justify-center text-lg">
                                +
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Es Kopi Cappuccino -->
                <article class="bg-[#D8B89A] rounded-[32px] shadow-lg overflow-hidden flex flex-col">
                    <img src="{{ asset('images/menu/eskopi-cappuccino.jpg') }}"
                         class="w-full h-40 md:h-52 object-cover">
                    <div class="flex-1 p-5 flex flex-col justify-between">
                        <div>
                            <h3 class="font-semibold text-lg text-[#3A2A20]">Es Kopi Cappuccino</h3>
                            <p class="text-sm text-[#4B3527] mt-2">
                                Cappuccino dingin dengan foam susu lembut dan aroma kopi ringan.
                            </p>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <span class="font-bold text-[#3A2A20]">12k</span>
                            <button
                                class="w-8 h-8 rounded-full bg-[#7A3E22] text-white flex items-center justify-center text-lg">
                                +
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Latte -->
                <article class="bg-[#D8B89A] rounded-[32px] shadow-lg overflow-hidden flex flex-col">
                    <img src="{{ asset('images/menu/latte.jpg') }}"
                         class="w-full h-40 md:h-52 object-cover">
                    <div class="flex-1 p-5 flex flex-col justify-between">
                        <div>
                            <h3 class="font-semibold text-lg text-[#3A2A20]">Latte</h3>
                            <p class="text-sm text-[#4B3527] mt-2">
                                Espresso berpadu susu creamy, rasa kopi halus dan milky.
                            </p>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <span class="font-bold text-[#3A2A20]">22k</span>
                            <button
                                class="w-8 h-8 rounded-full bg-[#7A3E22] text-white flex items-center justify-center text-lg">
                                +
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Es Kopi Susu -->
                <article class="bg-[#D8B89A] rounded-[32px] shadow-lg overflow-hidden flex flex-col">
                    <img src="{{ asset('images/menu/eskopi-susu.jpg') }}"
                         class="w-full h-40 md:h-52 object-cover">
                    <div class="flex-1 p-5 flex flex-col justify-between">
                        <div>
                            <h3 class="font-semibold text-lg text-[#3A2A20]">Es Kopi Susu</h3>
                            <p class="text-sm text-[#4B3527] mt-2">
                                Kopi susu dingin manis-gurih, cocok buat yang suka kopi ringan.
                            </p>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <span class="font-bold text-[#3A2A20]">22k</span>
                            <button
                                class="w-8 h-8 rounded-full bg-[#7A3E22] text-white flex items-center justify-center text-lg">
                                +
                            </button>
                        </div>
                    </div>
                </article>

            </div>
        </div>

        <!-- ====== NON KOPI ====== -->
        <div>
            <h2 class="text-3xl md:text-4xl font-extrabold text-[#FF3A20] mb-6">Non Kopi</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <!-- Es Coklat -->
                <article class="bg-[#D8B89A] rounded-[32px] shadow-lg overflow-hidden flex flex-col">
                    <img src="{{ asset('images/menu/escoklat.jpg') }}"
                         class="w-full h-40 md:h-52 object-cover">
                    <div class="flex-1 p-5 flex flex-col justify-between">
                        <div>
                            <h3 class="font-semibold text-lg text-[#3A2A20]">Es Coklat</h3>
                            <p class="text-sm text-[#4B3527] mt-2">
                                Minuman cokelat nikmat, manis dan rich.
                            </p>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <span class="font-bold text-[#3A2A20]">15k</span>
                            <button
                                class="w-8 h-8 rounded-full bg-[#7A3E22] text-white flex items-center justify-center text-lg">
                                +
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Teh Lemon -->
                <article class="bg-[#D8B89A] rounded-[32px] shadow-lg overflow-hidden flex flex-col">
                    <img src="{{ asset('images/menu/teh-lemon.jpg') }}"
                         class="w-full h-40 md:h-52 object-cover">
                    <div class="flex-1 p-5 flex flex-col justify-between">
                        <div>
                            <h3 class="font-semibold text-lg text-[#3A2A20]">Teh Lemon</h3>
                            <p class="text-sm text-[#4B3527] mt-2">
                                Teh segar dengan perasan lemon, asam-manis menyegarkan.
                            </p>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <span class="font-bold text-[#3A2A20]">12k</span>
                            <button
                                class="w-8 h-8 rounded-full bg-[#7A3E22] text-white flex items-center justify-center text-lg">
                                +
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Matcha Latte -->
                <article class="bg-[#D8B89A] rounded-[32px] shadow-lg overflow-hidden flex flex-col">
                    <img src="{{ asset('images/menu/matcha-latte.jpg') }}"
                         class="w-full h-40 md:h-52 object-cover">
                    <div class="flex-1 p-5 flex flex-col justify-between">
                        <div>
                            <h3 class="font-semibold text-lg text-[#3A2A20]">Matcha Latte</h3>
                            <p class="text-sm text-[#4B3527] mt-2">
                                Matcha berpadu susu creamy dengan rasa teh hijau khas.
                            </p>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <span class="font-bold text-[#3A2A20]">17k</span>
                            <button
                                class="w-8 h-8 rounded-full bg-[#7A3E22] text-white flex items-center justify-center text-lg">
                                +
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Teh Tarik -->
                <article class="bg-[#D8B89A] rounded-[32px] shadow-lg overflow-hidden flex flex-col">
                    <img src="{{ asset('images/menu/teh-tarik.jpg') }}"
                         class="w-full h-40 md:h-52 object-cover">
                    <div class="flex-1 p-5 flex flex-col justify-between">
                        <div>
                            <h3 class="font-semibold text-lg text-[#3A2A20]">Teh Tarik</h3>
                            <p class="text-sm text-[#4B3527] mt-2">
                                Teh susu manis dengan aroma karamel dan tekstur legit.
                            </p>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <span class="font-bold text-[#3A2A20]">15k</span>
                            <button
                                class="w-8 h-8 rounded-full bg-[#7A3E22] text-white flex items-center justify-center text-lg">
                                +
                            </button>
                        </div>
                    </div>
                </article>

            </div>
        </div>

        <!-- ====== TRADISIONAL ====== -->
        <div>
            <h2 class="text-3xl md:text-4xl font-extrabold text-[#FF3A20] mb-6">Tradisional</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <!-- Wedang Uwuh -->
                <article class="bg-[#D8B89A] rounded-[32px] shadow-lg overflow-hidden flex flex-col">
                    <img src="{{ asset('images/menu/wedang-uwuh.jpg') }}"
                         class="w-full h-40 md:h-52 object-cover">
                    <div class="flex-1 p-5 flex flex-col justify-between">
                        <div>
                            <h3 class="font-semibold text-lg text-[#3A2A20]">Wedang Uwuh</h3>
                            <p class="text-sm text-[#4B3527] mt-2">
                                Minuman rempah hangat khas Jawa, wangi dan menghangatkan tubuh.
                            </p>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <span class="font-bold text-[#3A2A20]">10k</span>
                            <button
                                class="w-8 h-8 rounded-full bg-[#7A3E22] text-white flex items-center justify-center text-lg">
                                +
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Es Sinom -->
                <article class="bg-[#D8B89A] rounded-[32px] shadow-lg overflow-hidden flex flex-col">
                    <img src="{{ asset('images/menu/es-sinom.jpg') }}"
                         class="w-full h-40 md:h-52 object-cover">
                    <div class="flex-1 p-5 flex flex-col justify-between">
                        <div>
                            <h3 class="font-semibold text-lg text-[#3A2A20]">Es Sinom</h3>
                            <p class="text-sm text-[#4B3527] mt-2">
                                Jamu sinom dingin dari asam jawa & kunyit, segar dan sedikit asam.
                            </p>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <span class="font-bold text-[#3A2A20]">10k</span>
                            <button
                                class="w-8 h-8 rounded-full bg-[#7A3E22] text-white flex items-center justify-center text-lg">
                                +
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Wedang Jahe -->
                <article class="bg-[#D8B89A] rounded-[32px] shadow-lg overflow-hidden flex flex-col">
                    <img src="{{ asset('images/menu/wedang-jahe.jpg') }}"
                         class="w-full h-40 md:h-52 object-cover">
                    <div class="flex-1 p-5 flex flex-col justify-between">
                        <div>
                            <h3 class="font-semibold text-lg text-[#3A2A20]">Wedang Jahe</h3>
                            <p class="text-sm text-[#4B3527] mt-2">
                                Jahe hangat manis, cocok untuk mengusir dingin.
                            </p>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <span class="font-bold text-[#3A2A20]">10k</span>
                            <button
                                class="w-8 h-8 rounded-full bg-[#7A3E22] text-white flex items-center justify-center text-lg">
                                +
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Es Timun Serut -->
                <article class="bg-[#D8B89A] rounded-[32px] shadow-lg overflow-hidden flex flex-col">
                    <img src="{{ asset('images/menu/es-timun-serut.jpg') }}"
                         class="w-full h-40 md:h-52 object-cover">
                    <div class="flex-1 p-5 flex flex-col justify-between">
                        <div>
                            <h3 class="font-semibold text-lg text-[#3A2A20]">Es Timun Serut</h3>
                            <p class="text-sm text-[#4B3527] mt-2">
                                Timun serut dingin dengan sirup manis, super fresh.
                            </p>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <span class="font-bold text-[#3A2A20]">10k</span>
                            <button
                                class="w-8 h-8 rounded-full bg-[#7A3E22] text-white flex items-center justify-center text-lg">
                                +
                            </button>
                        </div>
                    </div>
                </article>

            </div>
        </div>

        <!-- ====== JAJANAN ====== -->
        <div>
            <h2 class="text-3xl md:text-4xl font-extrabold text-[#FF3A20] mb-6">Jajanan</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <!-- Tahu Crispy -->
                <article class="bg-[#D8B89A] rounded-[32px] shadow-lg overflow-hidden flex flex-col">
                    <img src="{{ asset('images/menu/tahu-crispy.jpg') }}"
                         class="w-full h-40 md:h-52 object-cover">
                    <div class="flex-1 p-5 flex flex-col justify-between">
                        <div>
                            <h3 class="font-semibold text-lg text-[#3A2A20]">Tahu Crispy</h3>
                            <p class="text-sm text-[#4B3527] mt-2">
                                Tahu goreng tepung garing, gurih dan ringan.
                            </p>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <span class="font-bold text-[#3A2A20]">22k</span>
                            <button
                                class="w-8 h-8 rounded-full bg-[#7A3E22] text-white flex items-center justify-center text-lg">
                                +
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Pisang Goreng -->
                <article class="bg-[#D8B89A] rounded-[32px] shadow-lg overflow-hidden flex flex-col">
                    <img src="{{ asset('images/menu/pisang-goreng.jpg') }}"
                         class="w-full h-40 md:h-52 object-cover">
                    <div class="flex-1 p-5 flex flex-col justify-between">
                        <div>
                            <h3 class="font-semibold text-lg text-[#3A2A20]">Pisang Goreng</h3>
                            <p class="text-sm text-[#4B3527] mt-2">
                                Pisang goreng renyah di luar, manis lembut di dalam.
                            </p>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <span class="font-bold text-[#3A2A20]">12k</span>
                            <button
                                class="w-8 h-8 rounded-full bg-[#7A3E22] text-white flex items-center justify-center text-lg">
                                +
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Tempe Mendoan -->
                <article class="bg-[#D8B89A] rounded-[32px] shadow-lg overflow-hidden flex flex-col">
                    <img src="{{ asset('images/menu/tempe-mendoan.jpg') }}"
                         class="w-full h-40 md:h-52 object-cover">
                    <div class="flex-1 p-5 flex flex-col justify-between">
                        <div>
                            <h3 class="font-semibold text-lg text-[#3A2A20]">Tempe Mendoan</h3>
                            <p class="text-sm text-[#4B3527] mt-2">
                                Tempe goreng setengah kering, lembut dan gurih.
                            </p>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <span class="font-bold text-[#3A2A20]">12k</span>
                            <button
                                class="w-8 h-8 rounded-full bg-[#7A3E22] text-white flex items-center justify-center text-lg">
                                +
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Mix Platter -->
                <article class="bg-[#D8B89A] rounded-[32px] shadow-lg overflow-hidden flex flex-col">
                    <img src="{{ asset('images/menu/mix-platter.jpg') }}"
                         class="w-full h-40 md:h-52 object-cover">
                    <div class="flex-1 p-5 flex flex-col justify-between">
                        <div>
                            <h3 class="font-semibold text-lg text-[#3A2A20]">Mix Platter</h3>
                            <p class="text-sm text-[#4B3527] mt-2">
                                Campuran beberapa gorengan pilihan untuk sharing.
                            </p>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <span class="font-bold text-[#3A2A20]">22k</span>
                            <button
                                class="w-8 h-8 rounded-full bg-[#7A3E22] text-white flex items-center justify-center text-lg">
                                +
                            </button>
                        </div>
                    </div>
                </article>

            </div>
        </div>

        <!-- ====== MAKANAN ====== -->
        <div>
            <h2 class="text-3xl md:text-4xl font-extrabold text-[#FF3A20] mb-6">Makanan</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <!-- Nasi Goreng Joglo + Telur -->
                <article class="bg-[#D8B89A] rounded-[32px] shadow-lg overflow-hidden flex flex-col">
                    <img src="{{ asset('images/menu/nasgor-joglo-telur.jpg') }}"
                         class="w-full h-40 md:h-52 object-cover">
                    <div class="flex-1 p-5 flex flex-col justify-between">
                        <div>
                            <h3 class="font-semibold text-lg text-[#3A2A20]">
                                Nasi Goreng Joglo + Telur
                            </h3>
                            <p class="text-sm text-[#4B3527] mt-2">
                                Nasi goreng bumbu khas rumahan, gurih dengan telur goreng.
                            </p>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <span class="font-bold text-[#3A2A20]">25k</span>
                            <button
                                class="w-8 h-8 rounded-full bg-[#7A3E22] text-white flex items-center justify-center text-lg">
                                +
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Mie Tek - Tek Telur -->
                <article class="bg-[#D8B89A] rounded-[32px] shadow-lg overflow-hidden flex flex-col">
                    <img src="{{ asset('images/menu/mie-tek-tek-telur.jpg') }}"
                         class="w-full h-40 md:h-52 object-cover">
                    <div class="flex-1 p-5 flex flex-col justify-between">
                        <div>
                            <h3 class="font-semibold text-lg text-[#3A2A20]">
                                Mie Tek - Tek Telur
                            </h3>
                            <p class="text-sm text-[#4B3527] mt-2">
                                Mie goreng ala joglo tek-tek dengan telur, smoky dan savory.
                            </p>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <span class="font-bold text-[#3A2A20]">21k</span>
                            <button
                                class="w-8 h-8 rounded-full bg-[#7A3E22] text-white flex items-center justify-center text-lg">
                                +
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Nasi Ayam Katsu -->
                <article class="bg-[#D8B89A] rounded-[32px] shadow-lg overflow-hidden flex flex-col">
                    <img src="{{ asset('images/menu/nasi-ayam-katsu.jpg') }}"
                         class="w-full h-40 md:h-52 object-cover">
                    <div class="flex-1 p-5 flex flex-col justify-between">
                        <div>
                            <h3 class="font-semibold text-lg text-[#3A2A20]">
                                Nasi Ayam Katsu
                            </h3>
                            <p class="text-sm text-[#4B3527] mt-2">
                                Nasi hangat dengan ayam katsu crispy dan saus gurih.
                            </p>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <span class="font-bold text-[#3A2A20]">27k</span>
                            <button
                                class="w-8 h-8 rounded-full bg-[#7A3E22] text-white flex items-center justify-center text-lg">
                                +
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Chicken Steak -->
                <article class="bg-[#D8B89A] rounded-[32px] shadow-lg overflow-hidden flex flex-col">
                    <img src="{{ asset('images/menu/chicken-steak.jpg') }}"
                         class="w-full h-40 md:h-52 object-cover">
                    <div class="flex-1 p-5 flex flex-col justify-between">
                        <div>
                            <h3 class="font-semibold text-lg text-[#3A2A20]">
                                Chicken Steak
                            </h3>
                            <p class="text-sm text-[#4B3527] mt-2">
                                Ayam steak dengan saus spesial, juicy dan mengenyangkan.
                            </p>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <span class="font-bold text-[#3A2A20]">27k</span>
                            <button
                                class="w-8 h-8 rounded-full bg-[#7A3E22] text-white flex items-center justify-center text-lg">
                                +
                            </button>
                        </div>
                    </div>
                </article>

            </div>
        </div>

    </section>

</body>
</html>
