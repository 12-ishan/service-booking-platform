<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Student extends Model
{
     use HasApiTokens;

    protected $table = 'student';

    protected $fillable = ['first_name', 'last_name', 'email', 'password'];

    public function application()
    {
        return $this->hasMany('App\Models\Admin\application');
    }
}