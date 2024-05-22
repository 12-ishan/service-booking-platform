<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class BlogManager extends Model
{
    protected $table = 'blog';

    public function category()
    {
        return $this->belongsTo('App\Models\Admin\BlogCategory', 'category_id', 'id');
    }

}