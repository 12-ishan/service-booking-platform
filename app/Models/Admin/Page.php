<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'page';

    public function image()
    {
        return $this->belongsTo('App\Model\Admin\Media', 'imageId', 'id');
    }

}