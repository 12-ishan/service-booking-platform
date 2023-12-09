<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'lms_order_item';

    public function program()
    {
        return $this->belongsTo('App\Model\Admin\Program', 'programId', 'id');
    }

    public function subject()
    {
        return $this->belongsTo('App\Model\Admin\Subject', 'subjectId', 'id');
    }

    public function topic()
    {
        return $this->belongsTo('App\Model\Admin\Topic', 'topicId', 'id');
    }

    public function state()
    {
        return $this->belongsTo('App\Model\Admin\States', 'stateId', 'id');
    }
}