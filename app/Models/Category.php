<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';  // Tên bảng
    protected $primaryKey = 'category_id';  // Khóa chính
    public $incrementing = false; // Nếu khóa chính không phải là kiểu số tự động tăng
    protected $keyType = 'string'; // Nếu khóa chính là kiểu chuỗi
    // Khai báo các cột có thể ghi dữ liệu
    protected $fillable = ['category_name', 'category_status'];

    // Bỏ qua timestamps nếu bảng không có các cột created_at và updated_at
    public $timestamps = false;
}
