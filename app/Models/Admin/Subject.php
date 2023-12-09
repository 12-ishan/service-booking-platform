<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'subject';

    // public function image()
    // {
    //     return $this->belongsTo('App\Model\Admin\Media', 'imageId', 'id');
    // }

    public function program()
    {
        return $this->belongsTo('App\Models\Admin\Program', 'programId', 'id');
    }

}