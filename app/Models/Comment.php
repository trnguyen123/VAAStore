<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments'; // Tên bảng trong database
    protected $primaryKey = 'comment_id'; // Khóa chính
    public $timestamps = false; // Tắt timestamps

    protected $fillable = [
        'product_id',
        'customer_id',
        'comment_content',
        'comment_rating',
        'comment_date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
