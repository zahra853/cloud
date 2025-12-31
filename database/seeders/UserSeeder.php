<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin Account
        User::create([
            "name" => "Admin",
            "email" => "admin@gmail.com",
            "role" => "admin",
            "password" => bcrypt("password"),
        ]);

        // Guest Account (for testing)
        User::create([
            "name" => "Guest User",
            "email" => "guest@gmail.com",
            "role" => "guest",
            "password" => bcrypt("password"),
        ]);

        // Regular Users/Members
        User::create([
            "name" => "Sonia",
            "email" => "sonia@gmail.com",
            "role" => "user",
            "password" => bcrypt("password"),
        ]);
        User::create([
            "name" => "Yanto",
            "email" => "yanto@gmail.com",
            "role" => "user",
            "password" => bcrypt("password"),
        ]);
        User::create([
            "name" => "Yayuk",
            "email" => "yayuk@gmail.com",
            "role" => "user",
            "password" => bcrypt("password"),
        ]);
        User::create([
            "name" => "Sugeng",
            "email" => "sugeng@gmail.com",
            "role" => "user",
            "password" => bcrypt("password"),
        ]);
        User::create([
            "name" => "Prili",
            "email" => "prili@gmail.com",
            "role" => "user",
            "password" => bcrypt("password"),
        ]);
        User::create([
            "name" => "Widi",
            "email" => "widi@gmail.com",
            "role" => "user",
            "password" => bcrypt("password"),
        ]);
        User::create([
            "name" => "Agus",
            "email" => "agus@gmail.com",
            "role" => "user",
            "password" => bcrypt("password"),
        ]);
        User::create([
            "name" => "Zaki",
            "email" => "zaki@gmail.com",
            "role" => "user",
            "password" => bcrypt("password"),
        ]);
        User::create([
            "name" => "Erlang",
            "email" => "erlang@gmail.com",
            "role" => "user",
            "password" => bcrypt("password"),
        ]);
        User::create([
            "name" => "Linda",
            "email" => "linda@gmail.com",
            "role" => "user",
            "password" => bcrypt("password"),
        ]);
        User::create([
            "name" => "Khaila",
            "email" => "khaila@gmail.com",
            "role" => "user",
            "password" => bcrypt("password"),
        ]);
    }
}
