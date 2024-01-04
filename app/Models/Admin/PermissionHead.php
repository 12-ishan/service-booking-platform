<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class PermissionHead extends Model
{
    protected $table = 'permission_head';

    public function role(){
        return $this->belongsToMany(RolePermission::class, 'role_permission');
    }
}
