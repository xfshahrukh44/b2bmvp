<?php

namespace App\Services;

use App\Repositories\ShippingRegionRepository;
use App\Models\ShippingRegion;
use Illuminate\Support\Facades\Auth;
// use Hash;

class ShippingRegionService extends ShippingRegionRepository
{
    public function search_shipping_regions($query)
    {
        // foreign fields

        // search block
        $shipping_regions = $this->model::where('page', 'LIKE', '%'.$query.'%')
                        ->orWhere('title', 'LIKE', '%'.$query.'%')
                        ->orWhere('subtitle', 'LIKE', '%'.$query.'%')
                        ->orWhere('description', 'LIKE', '%'.$query.'%')
                        ->orWhere('status', 'LIKE', '%'.$query.'%')
                        ->paginate(env('PAGINATION'));

        return $shipping_regions;
    }
}