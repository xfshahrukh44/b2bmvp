<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProvinceService;

class ProvinceController extends Controller
{
    
    protected $provinceService;

    public function __construct(ProvinceService $provinceService)
    {
        $this->provinceService = $provinceService;
    }

    public function find(Request $request, $id)
    {
        return ($this->provinceService->find($id))['province'];
    }
}
