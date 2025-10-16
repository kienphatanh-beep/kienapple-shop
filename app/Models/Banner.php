<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    protected $table = 'banner';  // Bảng của bạn là 'banner'
    use SoftDeletes;  // Sử dụng soft delete nếu cần

    // Nếu cần có các thuộc tính có thể gán, thêm vào
    protected $fillable = ['name', 'image', 'status', 'position', 'sort_order'];
}
