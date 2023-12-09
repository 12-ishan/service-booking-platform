<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $table = 'meeting';

    public function image()
    {
        return $this->belongsTo('App\Models\Admin\Media', 'imageId', 'id');
    }
    public function pdf()
    {
        return $this->belongsTo('App\Models\Admin\Media', 'pdfId', 'id');
    }
    public function teacher()
    {
        return $this->belongsTo('App\Models\Admin\User', 'tutorId', 'id');
    }

    public function program()
    {
        return $this->belongsTo('App\Models\Admin\Program', 'programId', 'id');
    }

    public function subject()
    {
        return $this->belongsTo('App\Models\Admin\Subject', 'subjectId', 'id');
    }

    public function topic()
    {
        return $this->belongsTo('App\Models\Admin\Topic', 'topicId', 'id');
    }

    // public function state()
    // {
    //     return $this->belongsTo('App\Model\Admin\States', 'stateId', 'id');
    // }

    public function timeSlot()
    {
        return $this->belongsTo('App\Models\Admin\TimeSlot', 'timeSlotId', 'id');
    }
    
    public function username()
    {
        return $this->belongsTo('App\Models\Admin\User', 'sessionRecieverId', 'id');
    }

    
}
