<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    // Đảm bảo rằng tên bảng là 'user', nếu tên bảng của bạn là 'user'
    protected $table = 'user'; 

    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'password',
        'address',
        'avatar',
        'roles',
        'created_by',
        'status',
    ];
    
}
