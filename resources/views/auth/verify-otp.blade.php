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

    <!-- LEFT SIDE -->
    <div class="relative hidden md:block">
        <img src="{{ asset('images/homepage/gambar2.png') }}" class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-cafe-700 bg-opacity-40 backdrop-blur-sm"></div>

        <!-- Back ke Forgot Password awal -->
        {{-- ganti route('password.request') sesuai route forgot password punyamu --}}
        <a href="{{ route('password.request') }}"
           class="absolute top-6 left-6 text-white text-3xl font-bold z-20">
            &larr;
        </a>

        <div class="absolute inset-0 flex flex-col justify-center items-center text-white px-6">
            <p class="text-center mt-2 font-medium">
                Masukkan kode OTP yang sudah kami kirim 💬
            </p>
        </div>
    </div>

    <!-- RIGHT SIDE -->
    <div class="bg-cafe-100 flex items-center justify-center p-6">
        <div class="bg-white w-full max-w-md rounded-3xl shadow-xl p-10">

            <h2 class="text-center text-2xl font-bold text-cafe-700 mb-2">
                Verify OTP
            </h2>

            <p class="text-center text-sm text-gray-500 mb-8 leading-relaxed">
                Enter your OTP which has been sent to your email and completely verify your account.
            </p>

            {{-- ganti ke route verifikasi OTP punyamu --}}
            <form method="POST" action="{{ route('otp.verify') }}">
                @csrf

                <!-- OTP Inputs -->
                <div class="flex justify-between max-w-xs mx-auto mb-4">
                    @for ($i = 0; $i < 6; $i++)
                        <input
                            type="text"
                            name="otp[]"
                            maxlength="1"
                            class="w-10 text-center text-lg border-b-2 border-gray-300 focus:outline-none focus:border-cafe-500"
                        />
                    @endfor
                </div>

                <p class="text-center text-xs text-gray-400 mb-1">
                    A code has been sent to your phone
                </p>
                <p class="text-center text-xs text-blue-500 mb-6">
                    Resend in 00:57
                </p>

                <button
                    class="w-full bg-cafe-500 text-white py-3 rounded-xl font-semibold hover:bg-cafe-700 transition">
                    Confirm
                </button>
            </form>

        </div>
    </div>

</body>

</html>
