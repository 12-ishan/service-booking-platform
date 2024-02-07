<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class LoginOtpVerification extends Model
{
    protected $table = 'login_otp_verification';
}