<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $primaryKey = 'product_id'; // Đặt khóa chính
    public $incrementing = false; // Đặt thành false vì product_id không phải là số nguyên
    protected $keyType = 'string'; // Đặt kiểu khóa chính là string
    public $timestamps = false;
    protected $table = 'products'; // Nếu bạn không đổi tên bảng, không cần dòng này

    // Khai báo các thuộc tính mà bạn cho phép gán hàng loạt
    protected $fillable = [
        'product_id',         
        'category_id',        
        'product_name',       
        'product_date',       
        'product_description',
        'product_amount',     
        'product_price',      
        'product_img',        
    ];

    // Một sản phẩm có thể thuộc về một danh mục
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }
}
