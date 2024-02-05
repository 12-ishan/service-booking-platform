<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    protected $table = 'payment_history';

    public function organisation()
    {
        return $this->belongsTo('App\Models\Admin\Organisation', 'organisation_id', 'id');
    }

    public function student()
    {
        return $this->belongsTo('App\Models\Frontend\Student', 'student_id', 'id');
    }
    public function program()
    {
        return $this->belongsTo('App\Models\Admin\Program', 'program_id', 'id');
    }
}