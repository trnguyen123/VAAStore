<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $table = 'favorites';
    protected $primaryKey = 'favorite_id';
    public $timestamps = false; // Tắt timestamps

    protected $fillable = [
        'product_id',
        'customer_id',
    ];
    public function product()
{
    return $this->belongsTo(Product::class, 'product_id');
}

}

