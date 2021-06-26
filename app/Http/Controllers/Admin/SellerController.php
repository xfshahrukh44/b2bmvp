<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SellerService;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class SellerController extends Controller
{
    public function __construct(SellerService $sellerService)
    {
        $this->sellerService = $sellerService;
        $this->middleware('auth:admin');
    }

    public function add_seller()
    {
        return view('admin.seller.add_seller');
    }

    public function create_seller(Request $request)
    {
        $request->validate([
            'first_name' => 'string|required|max:50',
            'last_name' => 'string|required|max:50',
            'profile_picture' => 'sometimes',
            'email' => 'required|email|unique:sellers',
            'phone' => 'required|unique:sellers',
            'password' => 'required',
            'company_name' => 'string|required|max:100',
            'company_logo' => 'sometimes',
            'account_status' => 'required',
            'is_approved' => 'sometimes',
        ]);

        // image work
        $req = Arr::except($request->all(),['profile_picture', 'company_logo']);
        // profile_picture
        if($request->profile_picture){
            $image = $request->profile_picture;
            $imageName = Str::random(10).'.png';
            Storage::disk('public_sellers')->put($imageName, \File::get($image));
            $req['profile_picture'] = $imageName;
        }
        // company_logo
        if($request->company_logo){
            $image = $request->company_logo;
            $imageName = Str::random(10).'.png';
            Storage::disk('public_companies')->put($imageName, \File::get($image));
            $req['company_logo'] = $imageName;
        }

        // password hashing
        $req['password'] = Hash::make($req['password']);

        // create seller
        $seller = ($this->sellerService->create($req))['seller']['seller'];

        // fire registration event
        event(new Registered($seller));

        // assign seller role
        $seller->assignRole('seller');

        $sellers = $this->sellerService->all();

        return view('admin.admin', compact('sellers'));
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

    public function activate_seller(Request $request)
    {
        return $this->sellerService->update([
            'account_status' => 1
        ], $request['seller_id']);
    }

    public function deactivate_seller(Request $request)
    {
        return $this->sellerService->update([
            'account_status' => 0
        ], $request['seller_id']);
    }
}
