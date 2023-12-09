<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'question';

    public function image()
    {
        return $this->belongsTo('App\Models\Admin\Media', 'imageId', 'id');
    }

    public function category()
    {
        
        return $this->belongsTo('App\Models\Admin\QuestionCategory', 'questionCategoryId', 'id');
    }

    public function questionOption()
    {
       // echo "hi";die;
        return $this->belongsTo('App\Models\Admin\QuestionOption', 'questionId', 'id');
    }
}