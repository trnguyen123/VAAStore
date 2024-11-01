<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $admin = new Admin();
        $admin->username = 'trnguyen';
        $admin->password = Hash::make('123456'); 
        $admin->admin_id = 'ADM00'; 
        $admin->save();
    }
}