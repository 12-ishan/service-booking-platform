<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Organisation extends Model
{
    protected $table = 'organisation';

    // public function image()
    // {
    //     return $this->belongsTo('App\Models\Admin\Media', 'imageId', 'id');
    // }

    // public function subject()
    // {
    //     return $this->hasMany('App\Models\Admin\Subject');
    // }

    // public function organisation()
    // {
    //     return $this->belongsTo('App\Models\Admin\Organisation', 'organisationId', 'id');
    // }
}