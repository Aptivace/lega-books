<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

         User::create([
             "first_name" => "admin",
             "last_name" => "admin",
             "patronymic" => "admin",
             "birth_date" => "1990-01-01",
             'email' => 'admin@admin.ru',
             'password' => 'admin123',
             "role" => "admin"
         ]);
    }
}
