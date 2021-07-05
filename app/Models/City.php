<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'province_id',
        'name'
    ];
    
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function province()
    {
        return $this->belongsTo('App\Models\Province');
    }

    public function sellers()
    {
        return $this->hasMany('App\Models\Seller');
    }
}