<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'plan';

    public function topic()
    {
        return $this->belongsTo('App\Model\Admin\Topic', 'topicId', 'id');
    }

    

}