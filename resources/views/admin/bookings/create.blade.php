@extends('admin.sidebar')

@section('container')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Create Booking</h1>
        <a href="{{ route('admin.bookings.index') }}" class="text-gray-600 hover:text-gray-800">
            <i class="fas fa-arrow-left mr-2"></i> Back
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.bookings.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-sm font-medium mb-1">Customer Name</label>
                    <input type="text" name="customer_name" value="{{ old('customer_name') }}" 
                           class="w-full px-4 py-2 border rounded-lg" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Phone</label>
                    <input type="tel" name="customer_phone" value="{{ old('customer_phone') }}" 
                           class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" name="customer_email" value="{{ old('customer_email') }}" 
                           class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Booking Date</label>
                    <input type="date" name="booking_date" value="{{ old('booking_date') }}" 
                           class="w-full px-4 py-2 border rounded-lg" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Booking Time</label>
                    <input type="time" name="booking_time" value="{{ old('booking_time') }}" 
                           class="w-full px-4 py-2 border rounded-lg" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Number of People</label>
                    <input type="number" name="number_of_people" value="{{ old('number_of_people', 2) }}" 
                           min="1" max="50" class="w-full px-4 py-2 border rounded-lg" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Status</label>
                    <select name="status" class="w-full px-4 py-2 border rounded-lg" required>
                        <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ old('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium mb-1">Notes</label>
                    <textarea name="notes" rows="3" 
                              class="w-full px-4 py-2 border rounded-lg">{{ old('notes') }}</textarea>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-save mr-2"></i> Create Booking
                </button>
            </div>
        </form>
    </div>
@endsection
