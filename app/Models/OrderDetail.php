<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'orderdetail'; // Nếu tên bảng trong DB là 'orderdetail'

    public $timestamps = false; // Bảng không có created_at, updated_at

    protected $fillable = [
        'order_id',
        'product_id',
        'price_buy',
        'qty',
        'amount'
    ];

    // Quan hệ với bảng orders
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Quan hệ với bảng products
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
