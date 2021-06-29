<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SellerDocument extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'seller_id',
        'title',
        'description',
        'file',
    ];
    
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function seller()
    {
        return $this->belongsTo('App\Models\Seller');
    }
}
