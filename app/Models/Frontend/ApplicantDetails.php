<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class ApplicantDetails extends Model
{
     use HasApiTokens;

    protected $table = 'applicant_details';

  //  protected $fillable = ['first_name', 'last_name', 'email', 'password'];

    public function application()
    {
        return $this->hasMany('App\Models\Admin\Application');
    }
    public function bloodGroup()
    {
        return $this->hasMany('App\Models\Admin\BloodGroup');
    }
    public function gender()
    {
        return $this->hasMany('App\Models\Admin\Gender');
    }
    public function state()
    {
        return $this->hasMany('App\Models\Admin\State');
    }
}