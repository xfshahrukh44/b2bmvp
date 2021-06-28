<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ShippingRegionService;

class ShippingRegionController extends Controller
{
    public function __construct(ShippingRegionService $shippingRegionService)
    {
        $this->shippingRegionService = $shippingRegionService;
        $this->middleware('auth:admin');
    }

    public function create_shipping_region(Request $request)
    {
        $request->validate([
            'title' => 'required|max:50',
            'time' => 'required|max:50',
            'price' => 'required',
        ]);

        // create shippingRegion
        return ($this->shippingRegionService->create($request->all()))['shipping_region']['shipping_region'];
    }

    public function update_shipping_region(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:50',
            'time' => 'required|max:50',
            'price' => 'required',
        ]);

        // update shippingRegion
        return ($this->shippingRegionService->update($request->all(), $id))['shipping_region']['shipping_region'];
    }

    public function destroy_shipping_region(Request $request, $id)
    {
        return ($this->shippingRegionService->delete($id))['shipping_region']['shipping_region'];
    }
}
