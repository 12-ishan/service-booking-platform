<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Scholarship extends Model
{
     use HasApiTokens;

    protected $table = 'scholarship';

    public function application()
    {
        return $this->hasMany('App\Models\Admin\Application');
    }
}