<!doctype html>
<html class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Membership - Joglo Lontar Cafe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');
        * { font-family: "Montserrat", sans-serif; }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">

    <div class="max-w-md mx-auto py-12 px-4">
        <div class="bg-white rounded-2xl shadow-xl p-8">
            
            <h1 class="text-2xl font-bold text-center text-gray-800 mb-2">Pembayaran Membership</h1>
            <p class="text-gray-500 text-center mb-8">Selesaikan pembayaran untuk aktifkan membership</p>

            <div class="bg-amber-50 border border-amber-200 rounded-xl p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-gray-600">Paket Membership</span>
                    <span class="font-semibold">1 Tahun</span>
                </div>
                <div class="flex justify-between items-center mb-4">
                    <span class="text-gray-600">Durasi</span>
                    <span class="font-semibold">{{ $duration }} hari</span>
                </div>
                <hr class="my-4 border-amber-200">
                <div class="flex justify-between items-center">
                    <span class="text-lg font-bold text-gray-800">Total</span>
                    <span class="text-lg font-bold text-amber-600">Rp {{ number_format($membershipFee, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6">
                <h3 class="font-semibold text-green-800 mb-2">Keuntungan Member:</h3>
                <ul class="text-green-700 text-sm space-y-1">
                    <li>✓ Akses voucher eksklusif member</li>
                    <li>✓ Diskon khusus setiap pembelian</li>
                    <li>✓ Promo spesial ulang tahun</li>
                    <li>✓ Prioritas booking meja</li>
                </ul>
            </div>

            <button id="pay-button"
                    class="w-full bg-amber-500 text-white py-4 rounded-xl font-semibold text-lg shadow-md hover:bg-amber-600 transition-all">
                Bayar Sekarang
            </button>

            <p class="mt-4 text-xs text-center text-gray-500">
                Pembayaran diproses secara aman oleh Midtrans
            </p>
        </div>
    </div>

    <script>
        document.getElementById('pay-button').onclick = function() {
            this.disabled = true;
            this.innerHTML = 'Memproses...';
            
            fetch('{{ route("membership.payment.create") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            window.location.href = '{{ route("membership.success") }}';
                        },
                        onPending: function(result) {
                            alert('Pembayaran pending. Silakan selesaikan pembayaran.');
                        },
                        onError: function(result) {
                            alert('Pembayaran gagal. Silakan coba lagi.');
                            document.getElementById('pay-button').disabled = false;
                            document.getElementById('pay-button').innerHTML = 'Bayar Sekarang';
                        },
                        onClose: function() {
                            document.getElementById('pay-button').disabled = false;
                            document.getElementById('pay-button').innerHTML = 'Bayar Sekarang';
                        }
                    });
                } else {
                    alert(data.message);
                    this.disabled = false;
                    this.innerHTML = 'Bayar Sekarang';
                }
            })
            .catch(error => {
                alert('Terjadi kesalahan. Silakan coba lagi.');
                document.getElementById('pay-button').disabled = false;
                document.getElementById('pay-button').innerHTML = 'Bayar Sekarang';
            });
        };
    </script>

</body>
</html>
