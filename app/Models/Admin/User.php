<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    public function image()
    {
        return $this->belongsTo('App\Models\Admin\Media', 'imageId', 'id');
    }
    public function role()
    {
        return $this->belongsTo('App\Models\Admin\Role', 'roleId', 'id');
    }
}