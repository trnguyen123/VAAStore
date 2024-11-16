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
        'password', // Không hiển thị mật khẩu
    ];
    public static function boot() {
    parent::boot();

    // Tự động tạo customer_id
    static::creating(function ($model) {
        // Lấy giá trị lớn nhất của customer_id hiện tại
        $maxCustomerId = Customer::max('customer_id');

        // Nếu không có khách hàng nào, khởi tạo giá trị mặc định
        if (empty($maxCustomerId)) {
            $model->customer_id = 'CUS01';
        } else {
            // Tách phần số từ customer_id
            $number = intval(substr($maxCustomerId, 3)); // Lấy phần số, bắt đầu từ ký tự thứ 4
            $newNumber = $number + 1; // Tăng giá trị lên 1
            $model->customer_id = 'CUS' . str_pad($newNumber, 2, '0', STR_PAD_LEFT); // Đặt lại giá trị customer_id
        }
    });
}

}
