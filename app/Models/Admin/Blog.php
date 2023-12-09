<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blog';

    public function image()
    {
        return $this->belongsTo('App\Model\Admin\Media', 'imageId', 'id');
    }
}