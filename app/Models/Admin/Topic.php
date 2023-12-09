<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $table = 'topic';

    public function subject()
    {
        return $this->belongsTo('App\Models\Admin\Subject', 'subjectId', 'id');
    }

    public function program()
    {
        return $this->belongsTo('App\Models\Admin\Program', 'programId', 'id');
    }


}