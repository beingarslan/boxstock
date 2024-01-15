<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            // 'name' => 'BoxStock',
            'company_name' => 'BoxStock',
            'user_name' => 'boxstock',
            'email' => 'admin@boxstock.com',
            'password' => Hash::make('12345678'),
            'type' => 1,
            'approved' => 1,
            'country' => 'Natherlands',
            'post_code' => '5800',
            'city' => 'Natherlands',
            'street_name' => 'Natherlands street',
            'phone_number' => '1456456456412'
        ]);
    }
}
