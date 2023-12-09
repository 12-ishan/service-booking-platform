<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $table = 'subscription';

    public function image()
    {
        return $this->belongsTo('App\Model\Admin\Media', 'imageId', 'id');
    }
}
