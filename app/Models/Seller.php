<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class Seller extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasFactory, SoftDeletes;

    protected $guard = 'seller';

    protected $fillable = [
        'first_name',
        'last_name',
        'profile_picture',
        'company_name',
        'company_logo',
        'business_address',
        'account_status',
        'is_approved',
        'email',
        'phone',
        'password',
        'otp',
        'is_verified',
        'email_verified_at',
    ];
    
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
