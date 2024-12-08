<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model{

    use HasFactory; 
    // Khóa chính của bảng
    protected $primaryKey = 'payment_id';

    public $timestamps = false;
    protected $keyType = 'string';
    protected $fillable = [ 'order_id','payment_id' ,'payment_date', 'payment_method', 'payment_status', 'payment_gateway', ]; 
    
    // Quan hệ với Order 
    public function order() { 
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
}
