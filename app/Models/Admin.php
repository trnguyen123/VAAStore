<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $table = 'admins'; // Tên bảng

    public $timestamps = false; // Tắt timestamps

    protected $fillable = [
        'username',
        'password',
    ];

    protected $hidden = [
        'password', // Ẩn mật khẩu khi trả về kết quả
    ];
}
