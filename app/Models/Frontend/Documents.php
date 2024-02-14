<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Documents extends Model
{
     use HasApiTokens;

    protected $table = 'documents';

    public function application()
    {
        return $this->hasMany('App\Models\Admin\Application');
    }
}