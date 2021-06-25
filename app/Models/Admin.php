<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use Notifiable, HasFactory, SoftDeletes, HasRoles;

    protected $guard = 'admin';

    protected $fillable = [
        'first_name',
        'last_name',
        'profile_picture',
        'email',
        'phone',
        'password',
    ];
    
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
