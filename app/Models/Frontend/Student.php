<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'student';

    public function application()
    {
        return $this->hasMany('App\Models\Admin\application');
    }
}