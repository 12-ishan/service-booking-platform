<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class MeetingTeacherScheduling extends Model
{
    protected $table = 'meeting_teacher_scheduling';

    public function image()
    {
        return $this->belongsTo('App\Model\Admin\Media', 'imageId', 'id');
    }
}