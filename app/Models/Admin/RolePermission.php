<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    protected $table = 'role_permission';
    // protected $fillable = ['roleId', 'permissionId'];

    // public function role(){
    //     return $this->belongsTo(Role::class);
    // }

    // public function permissionHead(){
    //     return $this->belongsTo(PermissionHead::class);
    // }

    
}
