<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Academics extends Model
{
     use HasApiTokens;

    protected $table = 'academics';

    public function application()
    {
        return $this->hasMany('App\Models\Admin\Application');
    }
}