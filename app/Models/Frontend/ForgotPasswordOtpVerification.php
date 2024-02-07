<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class ForgotPasswordOtpVerification extends Model
{
    protected $table = 'forgot_password_otp_verification';
}