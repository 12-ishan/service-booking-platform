<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'lms_order';

    public function username()
    {

        return $this->belongsTo('App\Model\Admin\User', 'userId', 'id');
    }
}