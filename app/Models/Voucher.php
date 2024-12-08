<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    // Tên bảng tương ứng trong cơ sở dữ liệu
    protected $table = 'vouchers';
    public $timestamps = false; // Tắt timestamps


    // Các trường có thể được gán giá trị (Mass Assignment)
    protected $fillable = [
        'code',
        'discount_value',
        'expiry_date',
        'status',
        'description',
    ];


    // Kiểm tra xem voucher đã hết hạn chưa
    public function isExpired()
    {
        return $this->expiry_date < now();
    }

    // Kiểm tra trạng thái voucher 
    public function isActive()
    {
        return $this->status === 'yes';
    }

    // Thêm phương thức khác nếu cần
}
