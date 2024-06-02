<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';

    protected $fillable = [
        'order_id',
        'status',
    ];
    

}