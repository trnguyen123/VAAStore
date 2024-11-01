<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::create([
            'full_name' => 'trung nguyen',
            'email' => 'nguyen@example.com',
            'username' => 'nguyen',
            'password' => Hash::make('123456'),
            'phone_number' => '0123456789',
            'address' => '123 Đường ABC, Quận 1, TP.HCM',
            'date_of_birth' => '2004-07-10',
            'gender' => 'Nam',
        ]);
    }
}
