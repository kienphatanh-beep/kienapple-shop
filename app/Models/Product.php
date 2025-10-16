<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

// class Product extends Model
// {
//     protected $table ='product';
//     use softDeletes;

// }




namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes; // Đảm bảo sử dụng SoftDeletes đúng

    protected $table = 'product'; // Xác định bảng trong CSDL

protected $fillable = [
    'category_id', 'brand_id', 'name', 'slug',
    'price_root', 'price_sale', 'thumbnail',
    'qty', 'stock', 'sold',
    'detail', 'description',
    'created_by', 'updated_by', 'status'
];


    // Quan hệ với bảng Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    // Quan hệ với bảng Brand
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }
    public function reviews()
{
    return $this->hasMany(ProductReview::class, 'product_id');
}

public function averageRating()
{
    return $this->reviews()->avg('rating') ?? 0;
}

}


