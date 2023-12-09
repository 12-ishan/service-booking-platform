<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = 'banner';

    public function image()
    {
        return $this->belongsTo('App\Model\Admin\Media', 'imageId', 'id');
    }
}
