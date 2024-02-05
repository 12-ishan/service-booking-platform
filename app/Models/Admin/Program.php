<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $table = 'program';

    public function image()
    {
        return $this->belongsTo('App\Models\Admin\Media', 'imageId', 'id');
    }

    public function subject()
    {
        return $this->hasMany('App\Models\Admin\Subject');
    }

    public function organisation()
    {
        return $this->belongsTo('App\Models\Admin\Organisation', 'organisationId', 'id');
    }
    public function application()
    {
        return $this->hasMany('App\Models\Admin\application');
    }
}