<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class TeacherClass extends Model
{
    protected $table = 'teacher_class';

    public function teacher()
    {
        return $this->belongsTo('App\Model\Admin\User', 'teacherId', 'id');
    }

    public function subject()
    {
        return $this->belongsTo('App\Model\Admin\Subject', 'subjectId', 'id');
    }

    public function program()
    {
        return $this->belongsTo('App\Model\Admin\Program', 'programId', 'id');
    }

   

}