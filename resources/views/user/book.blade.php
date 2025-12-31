<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Table - Joglo Lontar Cafe</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap');

        body, input, select, textarea {
            font-family: "Poppins", sans-serif;
        }

        .title {
            font-family: "Fredoka One", cursive;
        }
    </style>
</head>

<body class="bg-[#C8A892]">

    <!-- ================= NAVBAR ================= -->


    <!-- ================= BACKGROUND SECTION ================= -->
    <section class="w-full h-auto relative">

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
             class="w-full h-[1200px] object-cover brightness-90">

        <div class="absolute inset-0 bg-black/20"></div>

        <!-- TITLE -->
        <h1 class="absolute top-36 left-1/2 -translate-x-1/2 text-[70px] title text-[#F6D9C0] drop-shadow-lg text-center">
            BOOK A TABLE
        </h1>

        <!-- FORM CONTAINER -->
        <div class="absolute top-64 left-1/2 -translate-x-1/2 w-[80%] max-w-4xl">

            <!-- FORM MULAI DI SINI -->
            <form action="{{ route('book.store') }}" method="POST">
                @csrf

                <!-- ROW 1: NAME & PHONE -->
                <div class="grid grid-cols-2 gap-8 mb-6">
                    <!-- NAME -->
                    <div>
                        <label class="block text-[#E74C3C] font-bold text-lg mb-1">NAME</label>
                        <div class="bg-white rounded-xl shadow-md flex items-center px-6 py-4">
                            <input
                                type="text"
                                name="guest_name"
                                placeholder="Your Name"
                                value="{{ auth()->check() ? auth()->user()->name : old('guest_name') }}"
                                class="flex-1 outline-none text-gray-600 text-lg"
                                required>
                            <i class="fa-regular fa-user text-xl text-gray-700"></i>
                        </div>
                    </div>

                    <!-- PHONE -->
                    <div>
                        <label class="block text-[#E74C3C] font-bold text-lg mb-1">PHONE</label>
                        <div class="bg-white rounded-xl shadow-md flex items-center px-6 py-4">
                            <input
                                type="tel"
                                name="guest_phone"
                                placeholder="08xxxxxxxxxx"
                                value="{{ old('guest_phone') }}"
                                class="flex-1 outline-none text-gray-600 text-lg"
                                required>
                            <i class="fa-solid fa-phone text-xl text-gray-700"></i>
                        </div>
                    </div>
                </div>

                <!-- EMAIL (Optional) -->
                <div class="mb-6">
                    <label class="block text-[#E74C3C] font-bold text-lg mb-1">EMAIL (Optional)</label>
                    <div class="bg-white rounded-xl shadow-md flex items-center px-6 py-4">
                        <input
                            type="email"
                            name="guest_email"
                            placeholder="your@email.com"
                            value="{{ auth()->check() ? auth()->user()->email : old('guest_email') }}"
                            class="flex-1 outline-none text-gray-600 text-lg">
                        <i class="fa-regular fa-envelope text-xl text-gray-700"></i>
                    </div>
                </div>

                <!-- DATE -->
                <label class="block text-[#E74C3C] font-bold text-lg mb-1">DATE</label>
                <div class="bg-white rounded-xl shadow-md flex items-center px-6 py-4 mb-6">
                    <input
                        type="date"
                        name="booking_date"
                        class="flex-1 outline-none text-gray-600 text-lg"
                        min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                        required>
                    <i class="fa-regular fa-calendar text-xl text-gray-700"></i>
                </div>

                <div class="grid grid-cols-2 gap-8">

                    <!-- TIME -->
                    <div>
                        <label class="block text-[#E74C3C] font-bold text-lg mb-1">TIME</label>
                        <div class="bg-white rounded-xl shadow-md flex items-center px-6 py-4">
                            <input
                                type="time"
                                name="booking_time"
                                class="flex-1 outline-none text-gray-600 text-lg"
                                required>
                            <i class="fa-regular fa-clock text-xl text-gray-700"></i>
                        </div>
                    </div>

                    <!-- PEOPLE -->
                    <div>
                        <label class="block text-[#E74C3C] font-bold text-lg mb-1">PEOPLE</label>
                        <div class="bg-white rounded-xl shadow-md flex items-center px-6 py-4">
                            <select
                                name="number_of_people"
                                class="flex-1 outline-none text-gray-600 text-lg"
                                required>
                                <option value="" disabled selected>Choose...</option>
                                <option value="1">1 Person</option>
                                <option value="2">2 People</option>
                                <option value="3">3 People</option>
                                <option value="4">4 People</option>
                                <option value="5">5 People</option>
                                <option value="6">6 People</option>
                                <option value="7">7 People</option>
                                <option value="8">8 People</option>
                                <option value="10">10+ People</option>
                            </select>
                            <i class="fa-solid fa-user-group text-xl text-gray-700"></i>
                        </div>
                    </div>

                </div>

                <!-- SPECIAL REQUEST -->
                <div class="mt-6">
                    <label class="block text-[#E74C3C] font-bold text-lg mb-1">SPECIAL REQUEST (Optional)</label>
                    <div class="bg-white rounded-xl shadow-md px-6 py-4">
                        <textarea
                            name="special_request"
                            rows="2"
                            placeholder="Any special requests..."
                            class="w-full outline-none text-gray-600 text-lg resize-none">{{ old('special_request') }}</textarea>
                    </div>
                </div>

                <!-- BUTTON -->
                <div class="flex justify-center mt-8">
                    <button
                        type="submit"
                        class="bg-[#3A2117] text-white text-lg font-semibold px-16 py-4 rounded-3xl hover:bg-[#4d2f21]">
                        BOOK NOW
                    </button>
                </div>

            </form>
            <!-- FORM SELESAI -->

        </div>

    </section>

    <!-- SUCCESS ALERT -->
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Booking Berhasil!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#3A2117',
        });
    </script>
    @endif

    @if($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: "{{ $errors->first() }}",
            confirmButtonColor: '#E74C3C',
        });
    </script>
    @endif

</body>
</html>
