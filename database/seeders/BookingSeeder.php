<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'user')->get();

        Booking::create([
            'user_id' => $users->first()->id,
            'booking_date' => Carbon::today()->addDays(1),
            'booking_time' => '19:00:00',
            'number_of_people' => 4,
            'special_request' => 'Window seat preferred',
            'status' => 'confirmed',
            'table_number' => 'T-05',
        ]);

        Booking::create([
            'user_id' => $users->skip(1)->first()?->id ?? $users->first()->id,
            'booking_date' => Carbon::today()->addDays(2),
            'booking_time' => '20:00:00',
            'number_of_people' => 2,
            'special_request' => null,
            'status' => 'pending',
            'table_number' => null,
        ]);

        Booking::create([
            'user_id' => null,
            'guest_name' => 'Budi Santoso',
            'guest_email' => 'budi@example.com',
            'guest_phone' => '081234567890',
            'booking_date' => Carbon::today()->addDays(3),
            'booking_time' => '18:30:00',
            'number_of_people' => 6,
            'special_request' => 'Birthday celebration, need cake',
            'status' => 'pending',
            'table_number' => null,
        ]);

        Booking::create([
            'user_id' => null,
            'guest_name' => 'Siti Rahayu',
            'guest_email' => 'siti@example.com',
            'guest_phone' => '085678901234',
            'booking_date' => Carbon::today()->addDays(5),
            'booking_time' => '12:00:00',
            'number_of_people' => 3,
            'special_request' => null,
            'status' => 'confirmed',
            'table_number' => 'T-12',
        ]);

        Booking::create([
            'user_id' => $users->skip(2)->first()?->id ?? $users->first()->id,
            'booking_date' => Carbon::today()->subDays(2),
            'booking_time' => '19:30:00',
            'number_of_people' => 5,
            'special_request' => 'Quiet area please',
            'status' => 'completed',
            'table_number' => 'T-08',
        ]);
    }
}
