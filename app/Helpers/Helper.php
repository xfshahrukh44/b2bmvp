<?php

use Carbon\Carbon;
use App\Models\Seller;
use App\Models\City;

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

function populate_cities_table(){
    $cities = [];
    if (($handle = fopen(asset('/pk.csv'), "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            array_push($cities, [
                $data[0],
                $data[1],
            ]);
        }
        fclose($handle);
    }

    foreach($cities as $city){
        $province_id = NULL;
        if($city[0] == 'city'){
            continue;
        }
        if($city[1] == 'Sindh'){
            $province_id = 1;
        }
        if($city[1] == 'Punjab'){
            $province_id = 2;
        }
        if($city[1] == 'Khyber Pakhtunkhwa'){
            $province_id = 3;
        }
        if($city[1] == 'Balochistan'){
            $province_id = 4;
        }
        if($city[1] == 'Islamabad'){
            $province_id = 5;
        }
        if($city[1] == 'Gilgit-Baltistan'){
            $province_id = 6;
        }
        if($city[1] == 'Azad Kashmir'){
            $province_id = 7;
        }

        City::create([
            'province_id' => $province_id,
            'name' => $city[0]
        ]);
    }
}