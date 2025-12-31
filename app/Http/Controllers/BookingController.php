<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display bookings for the current user
     */
    public function myBookings()
    {
        $bookings = Auth::user()->bookings()->orderBy('booking_date', 'desc')->paginate(10);
        return view('user.bookings.index', compact('bookings'));
    }

    /**
     * User: Cancel their own booking
     */
    public function cancel(Booking $booking)
    {
        // Check if booking belongs to current user
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }
        
        // Only pending bookings can be cancelled
        if ($booking->status !== 'pending') {
            return back()->with('error', 'Only pending bookings can be cancelled');
        }
        
        $booking->update(['status' => 'cancelled']);
        return back()->with('success', 'Booking cancelled successfully');
    }

    /**
     * Show the booking form
     */
    public function create()
    {
        return view('user.book');
    }

    /**
     * Store a new booking
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_date' => 'required|date|after:today',
            'booking_time' => 'required',
            'number_of_people' => 'required|integer|min:1|max:50',
            'special_request' => 'nullable|string|max:500',
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'nullable|email',
            'guest_phone' => 'required|string|max:20',
        ]);

        $bookingData = [
            'booking_date' => $validated['booking_date'],
            'booking_time' => $validated['booking_time'],
            'number_of_people' => $validated['number_of_people'],
            'notes' => $validated['special_request'] ?? null,
            'status' => 'pending',
            'customer_name' => $validated['guest_name'],
            'customer_email' => $validated['guest_email'] ?? null,
            'customer_phone' => $validated['guest_phone'],
        ];

        // If user is logged in, associate booking with user
        if (Auth::check()) {
            $bookingData['user_id'] = Auth::id();
        }

        Booking::create($bookingData);

        return redirect()->back()
            ->with('success', 'Reservasi meja berhasil! Tunggu konfirmasi dari admin melalui WhatsApp/Email.');
    }

    /**
     * Show booking confirmation page
     */
    public function confirmed($id)
    {
        $booking = Booking::findOrFail($id);
        return view('user.book-confirmed', compact('booking'));
    }

    /**
     * Admin: Display all bookings
     */
    public function index()
    {
        $bookings = Booking::with('user')
            ->orderBy('booking_date', 'desc')
            ->orderBy('booking_time', 'desc')
            ->paginate(20);
        
        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Admin: Update booking status
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'table_number' => 'nullable|string|max:10',
        ]);

        $booking->update($validated);

        return back()->with('success', 'Status booking berhasil diupdate!');
    }

    /**
     * Admin: Delete booking
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return back()->with('success', 'Booking berhasil dihapus!');
    }

    /**
     * Admin: Show create booking form
     */
    public function adminCreate()
    {
        return view('admin.bookings.create');
    }

    /**
     * Admin: Store new booking
     */
    public function adminStore(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'customer_email' => 'nullable|email',
            'booking_date' => 'required|date',
            'booking_time' => 'required',
            'number_of_people' => 'required|integer|min:1|max:50',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'notes' => 'nullable|string|max:500',
        ]);

        Booking::create($validated);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking berhasil dibuat!');
    }

    /**
     * Admin: Show edit booking form
     */
    public function adminEdit(Booking $booking)
    {
        return view('admin.bookings.edit', compact('booking'));
    }

    /**
     * Admin: Update booking
     */
    public function adminUpdate(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'customer_email' => 'nullable|email',
            'booking_date' => 'required|date',
            'booking_time' => 'required',
            'number_of_people' => 'required|integer|min:1|max:50',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'notes' => 'nullable|string|max:500',
        ]);

        $booking->update($validated);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking berhasil diupdate!');
    }
}
