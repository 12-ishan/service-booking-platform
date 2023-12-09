<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $table = 'testimonial';

    public function image()
    {
        return $this->belongsTo('App\Model\Admin\Media', 'imageId', 'id');
    }
}
