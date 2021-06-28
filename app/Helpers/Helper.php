<?php

use Carbon\Carbon;
use App\Models\Seller;

function return_date($date)
{
    return Carbon::parse($date)->format('j F, Y. h:i a');
}

function get_slug($string){
    return strtolower(preg_replace('/\s+/', '-', $string));
}

function get_seller_slug($query){
    // fist name and last name
    $slug = $query['first_name'] . ' ' . $query['last_name'];

    // add company name if present
    if(isset($query['company_name'])){
        $slug .= ' ' . $query['company_name'];
    }

    // get initial slug
    $slug = get_slug($slug);

    // check for unique
    $sellers = Seller::where('slug', $slug)->get();
    // if not unique, append id
    if(count($sellers) > 0){
        $slug .= '-' . $query['id'];
    }

    return $slug;
}