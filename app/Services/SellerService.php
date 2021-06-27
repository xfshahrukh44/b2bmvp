<?php

namespace App\Services;

use App\Repositories\SellerRepository;
use App\Models\Seller;
use Illuminate\Support\Facades\Auth;
// use Hash;

class SellerService extends SellerRepository
{
    public function search_sellers($query)
    {
        // foreign fields

        // search block
        $sellers = $this->model::where('page', 'LIKE', '%'.$query.'%')
                        ->orWhere('title', 'LIKE', '%'.$query.'%')
                        ->orWhere('subtitle', 'LIKE', '%'.$query.'%')
                        ->orWhere('description', 'LIKE', '%'.$query.'%')
                        ->orWhere('status', 'LIKE', '%'.$query.'%')
                        ->paginate(env('PAGINATION'));

        return $sellers;
    }
}