<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $table = 'application';

    public function student()
    {
        return $this->belongsTo('App\Models\Frontend\Student', 'student_id', 'id');
    }

    public function program()
    {
        return $this->belongsTo('App\Models\Admin\Program', 'programId', 'id');
    }

   

}