<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class AwardsRecognition extends Model
{
     use HasApiTokens;

    protected $table = 'awards_recognition';

    public function application()
    {
        return $this->hasMany('App\Models\Admin\Application');
    }
}