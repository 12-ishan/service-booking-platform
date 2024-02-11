<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class ParentDetails extends Model
{
     use HasApiTokens;

    protected $table = 'parent_details';

    public function application()
    {
        return $this->hasMany('App\Models\Admin\Application');
    }
}