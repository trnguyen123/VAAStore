<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Tắt timestamps nếu không sử dụng cột `created_at` và `updated_at`
    public $timestamps = false;

    // Khóa chính của bảng
    protected $primaryKey = 'order_id';

    // Khóa chính không tự động tăng (nếu sử dụng kiểu chuỗi cho `order_id`)
    public $incrementing = false;

    // Loại dữ liệu của khóa chính (nếu là chuỗi)
    protected $keyType = 'string';

    // Các cột có thể được gán giá trị trực tiếp
    protected $fillable = [
        'order_id',
        'customer_id',
        'payment_id',
        'shipping_id',
        'order_note',
        'address',
        'shipping_date',
        'order_date',
        'order_status',
    ];

    protected $casts = [
        'shipping_date' => 'datetime',
        'order_date' => 'datetime',
    ];

    // Quan hệ với bảng `order_details` (1-N)
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'order_id');
    }

     //Quan hệ với bảng `payments` (1-1)
    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id', 'order_id');
    }

    public function scopeOrderedOn($query, $date)
    {
        return $query->whereDate('order_date', $date);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

}
