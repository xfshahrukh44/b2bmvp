<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SellerService;

class DashboardController extends Controller
{
    public function __construct(SellerService $sellerService)
    {
        $this->sellerService = $sellerService;
    }

    public function index(Request $request)
    {
        $sellers = $this->sellerService->all();

        return view('admin.admin', compact('sellers'));
    }
}
