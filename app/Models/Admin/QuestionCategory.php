<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class QuestionCategory extends Model
{
    protected $table = 'question_category';

    public function program()
    {
        return $this->belongsTo('App\Models\Admin\Program', 'programId', 'id');
    }
    public function subject()
    {
        return $this->belongsTo('App\Models\Admin\Subject', 'subjectId', 'id');
    }
    public function state()
    {
        return $this->belongsTo('App\Models\Admin\States', 'stateId', 'id');
    }
    
}