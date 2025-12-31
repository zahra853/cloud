@extends('user.navbar')

@section('container')
<div class="max-w-4xl mx-auto py-8 px-4">
    <h1 class="text-3xl font-bold mb-6">My Bookings</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-6">
        <a href="{{ route('book') }}" class="inline-block px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600">
            <i class="fas fa-plus mr-2"></i> Book a Table
        </a>
    </div>

    @if($bookings->count() > 0)
        <div class="space-y-4">
            @foreach($bookings as $booking)
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-bold text-lg">{{ $booking->booking_date }} at {{ $booking->booking_time }}</p>
                            <p class="text-gray-600">{{ $booking->number_of_people }} people</p>
                            @if($booking->notes)
                                <p class="text-sm text-gray-500 mt-2">Notes: {{ $booking->notes }}</p>
                            @endif
                        </div>
                        <span class="px-3 py-1 rounded text-sm
                            @if($booking->status === 'confirmed') bg-green-100 text-green-800
                            @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($booking->status === 'completed') bg-blue-100 text-blue-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>

                    @if($booking->status === 'pending')
                        <div class="mt-4 pt-4 border-t">
                            <form action="{{ route('user.bookings.cancel', $booking) }}" method="POST" 
                                  onsubmit="return confirm('Cancel this booking?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                    <i class="fas fa-times mr-1"></i> Cancel Booking
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        @if($bookings->hasPages())
            <div class="mt-6">
                {{ $bookings->links() }}
            </div>
        @endif
    @else
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <i class="fas fa-calendar text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 mb-4">No bookings yet</p>
            <a href="{{ route('book') }}" class="inline-block px-6 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600">
                Book a Table
            </a>
        </div>
    @endif
</div>
@endsection
