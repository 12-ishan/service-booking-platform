<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    protected $table = 'blog_category';

    public function blog()
    {
        return $this->hasMany('App\Models\Admin\BlogManager');
    }
}