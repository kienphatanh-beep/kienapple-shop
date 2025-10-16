<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    protected $table ='post';
    use softDeletes;

    public function topic()
{
    return $this->belongsTo(Topic::class);
}

}




