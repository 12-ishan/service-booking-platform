<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    protected $table = 'time_slot';

    public function image()
    {
        return $this->belongsTo('App\Models\Admin\Media', 'imageId', 'id');
    }
    
}