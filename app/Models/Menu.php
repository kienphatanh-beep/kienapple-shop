<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;

    protected $table = 'menu';

    protected $fillable = [
        'name', 'link', 'parent_id', 'sort_order', 'type', 'position',
        'status', 'created_by', 'updated_by',
    ];

    // Quan hệ menu con
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id')
                    ->where('status', 1)
                    ->orderBy('sort_order', 'asc');
    }
}
