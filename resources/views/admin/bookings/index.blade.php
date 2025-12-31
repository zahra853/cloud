@extends('admin.sidebar')

@section('container')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Bookings Management</h1>
        <a href="{{ route('admin.bookings.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i> Add Booking
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">People</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Notes</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($bookings as $booking)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <p class="font-medium">{{ $booking->customer_name }}</p>
                            <p class="text-sm text-gray-500">{{ $booking->customer_phone ?? '-' }}</p>
                            <p class="text-sm text-gray-500">{{ $booking->customer_email ?? '-' }}</p>
                        </td>
                        <td class="px-6 py-4 font-semibold">{{ $booking->booking_date }}</td>
                        <td class="px-6 py-4">{{ $booking->booking_time }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="bg-gray-100 px-3 py-1 rounded-full">{{ $booking->number_of_people }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-xs
                                @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($booking->status === 'completed') bg-blue-100 text-blue-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                            {{ $booking->notes ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2 flex-wrap">
                                @if($booking->status === 'pending')
                                    <form action="{{ route('admin.bookings.update-status', $booking) }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="status" value="confirmed">
                                        <button type="submit" class="text-green-600 hover:underline text-sm">Confirm</button>
                                    </form>
                                    <form action="{{ route('admin.bookings.update-status', $booking) }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="status" value="cancelled">
                                        <button type="submit" class="text-red-600 hover:underline text-sm">Cancel</button>
                                    </form>
                                @elseif($booking->status === 'confirmed')
                                    <form action="{{ route('admin.bookings.update-status', $booking) }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="status" value="completed">
                                        <button type="submit" class="text-blue-600 hover:underline text-sm">Complete</button>
                                    </form>
                                @endif
                                <a href="{{ route('admin.bookings.edit', $booking) }}" class="text-blue-600 hover:underline text-sm">Edit</a>
                                <form action="{{ route('admin.bookings.delete', $booking) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Delete this booking?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                            No bookings yet
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($bookings->hasPages())
        <div class="mt-4">
            {{ $bookings->links() }}
        </div>
    @endif
@endsection
