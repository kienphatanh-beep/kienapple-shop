<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topic extends Model
{
    
        use SoftDeletes;
    
        protected $table = 'topic';
        protected $fillable = [
                'name', 'slug', 'description', 'status', 'created_by', 'updated_by'
            ];
            

}
