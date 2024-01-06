<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role';

    public function permissionHead(){
        
        return $this->belongsTo(RolePermission::class, 'role_permission');
    }
}
