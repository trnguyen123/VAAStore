<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Customer extends Authenticatable
{
    protected $table = 'customers'; // tên bảng
    public $timestamps = false; // Tắt timestamps

    protected $fillable = [
        'customer_id',
        'full_name',
        'email',
        'username',
        'password',
        'phone_number',
        'address',
        'date_of_birth',
        'gender',
    ];
    protected $hidden = [
        'password', // Để không hiển thị mật khẩu
    ];
}
