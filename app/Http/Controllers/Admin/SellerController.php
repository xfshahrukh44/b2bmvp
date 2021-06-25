<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SellerService;

class SellerController extends Controller
{
    public function __construct(SellerService $sellerService)
    {
        $this->sellerService = $sellerService;
        $this->middleware('auth:admin');
    }

    public function approve_seller(Request $request)
    {
        return $this->sellerService->update([
            'is_approved' => 1
        ], $request['seller_id']);
    }

    public function reject_seller(Request $request)
    {
        return $this->sellerService->update([
            'is_approved' => 0
        ], $request['seller_id']);
    }
}
