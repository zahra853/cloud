@extends('user.dashboard.layout')

@section('title', 'My Bookings')
@section('page-title', 'My Bookings')

@section('content')
<!-- Booking Form Section -->
<div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
    <div class="p-4 border-b bg-gradient-to-r from-[#7A3E22] to-[#5C2E1A] text-white">
        <h3 class="font-bold text-lg flex items-center gap-2">
            <i class="fas fa-calendar-plus"></i>
            Reservasi Meja Baru
        </h3>
    </div>
    
    <form action="{{ route('user.dashboard.bookings.store') }}" method="POST" class="p-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Tanggal -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-calendar-alt mr-1 text-[#7A3E22]"></i>Tanggal Reservasi
                </label>
                <input type="date" name="booking_date" required
                       min="{{ date('Y-m-d') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#7A3E22] focus:border-transparent"
                       value="{{ old('booking_date') }}">
                @error('booking_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Waktu -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-clock mr-1 text-[#7A3E22]"></i>Waktu
                </label>
                <select name="booking_time" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#7A3E22] focus:border-transparent">
                    <option value="">Pilih Waktu</option>
                    <option value="10:00" {{ old('booking_time') == '10:00' ? 'selected' : '' }}>10:00</option>
                    <option value="11:00" {{ old('booking_time') == '11:00' ? 'selected' : '' }}>11:00</option>
                    <option value="12:00" {{ old('booking_time') == '12:00' ? 'selected' : '' }}>12:00</option>
                    <option value="13:00" {{ old('booking_time') == '13:00' ? 'selected' : '' }}>13:00</option>
                    <option value="14:00" {{ old('booking_time') == '14:00' ? 'selected' : '' }}>14:00</option>
                    <option value="15:00" {{ old('booking_time') == '15:00' ? 'selected' : '' }}>15:00</option>
                    <option value="16:00" {{ old('booking_time') == '16:00' ? 'selected' : '' }}>16:00</option>
                    <option value="17:00" {{ old('booking_time') == '17:00' ? 'selected' : '' }}>17:00</option>
                    <option value="18:00" {{ old('booking_time') == '18:00' ? 'selected' : '' }}>18:00</option>
                    <option value="19:00" {{ old('booking_time') == '19:00' ? 'selected' : '' }}>19:00</option>
                    <option value="20:00" {{ old('booking_time') == '20:00' ? 'selected' : '' }}>20:00</option>
                    <option value="21:00" {{ old('booking_time') == '21:00' ? 'selected' : '' }}>21:00</option>
                </select>
                @error('booking_time')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jumlah Orang -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-users mr-1 text-[#7A3E22]"></i>Jumlah Orang
                </label>
                <select name="number_of_people" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#7A3E22] focus:border-transparent">
                    @for($i = 1; $i <= 20; $i++)
                        <option value="{{ $i }}" {{ old('number_of_people') == $i ? 'selected' : '' }}>{{ $i }} orang</option>
                    @endfor
                </select>
                @error('number_of_people')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nomor Meja (Optional) -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-chair mr-1 text-[#7A3E22]"></i>Preferensi Meja (Opsional)
                </label>
                <select name="table_number"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#7A3E22] focus:border-transparent">
                    <option value="">Tidak ada preferensi</option>
                    <option value="1" {{ old('table_number') == '1' ? 'selected' : '' }}>Meja 1 - Indoor</option>
                    <option value="2" {{ old('table_number') == '2' ? 'selected' : '' }}>Meja 2 - Indoor</option>
                    <option value="3" {{ old('table_number') == '3' ? 'selected' : '' }}>Meja 3 - Indoor</option>
                    <option value="4" {{ old('table_number') == '4' ? 'selected' : '' }}>Meja 4 - Outdoor</option>
                    <option value="5" {{ old('table_number') == '5' ? 'selected' : '' }}>Meja 5 - Outdoor</option>
                    <option value="VIP" {{ old('table_number') == 'VIP' ? 'selected' : '' }}>VIP Room</option>
                </select>
            </div>

            <!-- Catatan -->
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-sticky-note mr-1 text-[#7A3E22]"></i>Catatan (Opsional)
                </label>
                <textarea name="notes" rows="3"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#7A3E22] focus:border-transparent"
                          placeholder="Contoh: Meja dekat jendela, ada anak kecil, dll">{{ old('notes') }}</textarea>
            </div>
        </div>

        <div class="mt-6">
            <button type="submit" class="w-full md:w-auto px-8 py-3 bg-[#7A3E22] text-white rounded-lg font-semibold hover:bg-[#5C2E1A] transition">
                <i class="fas fa-check mr-2"></i>Buat Reservasi
            </button>
        </div>
    </form>
</div>

<!-- Booking History -->
<div class="bg-white rounded-2xl shadow-lg overflow-hidden">
    <div class="p-4 border-b bg-gray-50">
        <h3 class="font-bold text-lg text-[#3A2A20]">Riwayat Reservasi</h3>
    </div>

    @forelse($bookings as $booking)
        <div class="p-6 border-b hover:bg-gray-50 transition">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <p class="font-bold text-lg text-[#3A2A20]">
                        <i class="fas fa-calendar-alt text-[#7A3E22] mr-2"></i>
                        {{ \Carbon\Carbon::parse($booking->booking_date)->format('l, d M Y') }}
                    </p>
                    <p class="text-gray-600 mt-1">
                        <i class="fas fa-clock mr-2"></i>{{ $booking->booking_time }}
                        <span class="mx-2">•</span>
                        <i class="fas fa-users mr-2"></i>{{ $booking->number_of_people }} orang
                    </p>
                    @if($booking->table_number)
                        <p class="text-sm text-gray-500 mt-1">
                            <i class="fas fa-chair mr-2"></i>Meja: {{ $booking->table_number }}
                        </p>
                    @endif
                    @if($booking->notes)
                        <p class="text-sm text-gray-500 mt-1">
                            <i class="fas fa-sticky-note mr-2"></i>{{ $booking->notes }}
                        </p>
                    @endif
                </div>
                <div class="text-right">
                    <span class="inline-block px-4 py-2 rounded-full font-semibold
                        {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-700' : 
                           ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 
                           ($booking->status === 'completed' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700')) }}">
                        {{ ucfirst($booking->status) }}
                    </span>

                    @if(in_array($booking->status, ['pending', 'confirmed']) && \Carbon\Carbon::parse($booking->booking_date)->isFuture())
                        <button onclick="cancelBooking({{ $booking->id }})" class="block mt-2 text-sm text-red-600 hover:underline">
                            <i class="fas fa-times mr-1"></i>Batalkan
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="p-8 text-center">
            <i class="fas fa-calendar-alt text-4xl text-gray-300 mb-3"></i>
            <p class="text-gray-500">Belum ada reservasi</p>
        </div>
    @endforelse

    @if($bookings->hasPages())
        <div class="p-4 border-t">
            {{ $bookings->links() }}
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function cancelBooking(bookingId) {
    Swal.fire({
        title: 'Batalkan Reservasi?',
        text: 'Apakah Anda yakin ingin membatalkan reservasi ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Batalkan',
        cancelButtonText: 'Tidak',
        buttonsStyling: false,
        customClass: {
            confirmButton: 'bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600 font-medium text-sm mx-2',
            cancelButton: 'bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 font-medium text-sm mx-2'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`{{ url('dashboard/bookings') }}/${bookingId}/cancel`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Reservasi berhasil dibatalkan',
                        buttonsStyling: false,
                        customClass: {
                            confirmButton: 'bg-green-500 text-white px-6 py-3 rounded-lg'
                        }
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: data.message || 'Terjadi kesalahan',
                        buttonsStyling: false,
                        customClass: {
                            confirmButton: 'bg-red-500 text-white px-6 py-3 rounded-lg'
                        }
                    });
                }
            });
        }
    });
}
</script>
@endpush