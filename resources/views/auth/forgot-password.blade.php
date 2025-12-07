<!doctype html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');
        * {
            font-family: "Montserrat", sans-serif;
        }
    </style>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cafe: {
                            50: '#F5ECE4',
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

<body class="h-screen grid grid-cols-1 md:grid-cols-2">

    <!-- LEFT SIDE (sama kayak login) -->
    <div class="relative hidden md:block">
        <img src="{{ asset('images/homepage/gambar2.png') }}" class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-cafe-700 bg-opacity-40 backdrop-blur-sm"></div>

        <!-- Back Button: balik ke login admin -->
        <a href="{{ route('login.admin') }}"
           class="absolute top-6 left-6 text-white text-3xl font-bold z-20">
            &larr;
        </a>

        <div class="absolute inset-0 flex flex-col justify-center items-center text-white px-6">
            <p class="text-center mt-2 font-medium">Lupa password? Tenang, kita bantu reset 💌</p>
        </div>
    </div>

    <!-- RIGHT SIDE -->
    <div class="bg-cafe-100 flex items-center justify-center p-6">
        <div class="bg-white w-full max-w-md rounded-3xl shadow-xl p-10">

            <!-- Title -->
            <h2 class="text-center text-2xl font-bold text-cafe-700 mb-2">
                Forgot Password
            </h2>

            <p class="text-center text-sm text-gray-500 mb-8 leading-relaxed">
                Enter the email associated with your account and we’ll send an email<br>
                with a code to reset your password.
            </p>

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email -->
                <label class="text-sm text-gray-700">Email</label>
                <input type="email" name="email"
                       class="w-full bg-cafe-50 px-4 py-3 rounded-xl border border-cafe-300 mt-1 mb-6 focus:ring-2 focus:ring-cafe-500"
                       placeholder="Text your email"
                       required />

                <!-- Button -->
                <button
                    class="w-full bg-cafe-500 text-white py-3 rounded-xl font-semibold hover:bg-cafe-700 transition">
                    Confirm
                </button>
            </form>

        </div>
    </div>

</body>

</html>
