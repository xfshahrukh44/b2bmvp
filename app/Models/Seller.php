<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\Seller\SellerResetPasswordNotification;
use Spatie\Permission\Traits\HasRoles;

class Seller extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasFactory, SoftDeletes, HasRoles;

    protected $guard = 'seller';

    protected $fillable = [
        'first_name',
        'last_name',
        'profile_picture',
        'company_name',
        'company_logo',
        'account_status',
        'is_approved',
        'email',
        'phone',
        'password',
        'otp',
        'is_verified',
        'email_verified_at',
        'remember_token',
        'slug',
    ];
    
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new SellerResetPasswordNotification($token));
    }

    public function saveQuietly(array $options = [])
    {
        return static::withoutEvents(function () use ($options) {
            return $this->save($options);
        });
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($query) {
            $query->slug = get_seller_slug($query);
            $query->saveQuietly();
        });
    }
}
