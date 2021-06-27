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
use Illuminate\Foundation\Auth\RegistersUsers;
use Carbon\Carbon;

class SellerController extends Controller
{
    use RegistersUsers;

    public function __construct(SellerService $sellerService)
    {
        $this->sellerService = $sellerService;
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $sellers = $this->sellerService->paginate(10);
        
        return view('admin.seller.index', compact('sellers'));
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

        // email_verified_at
        $req['email_verified_at'] = Carbon::now();

        // create seller
        $seller = ($this->sellerService->create($req))['seller']['seller'];

        // fire registration event
        event(new Registered($seller));

        // assign seller role
        $seller->assignRole('seller');

        return $this->index();
    }

    public function edit_seller($slug)
    {
        $seller = $this->sellerService->find_by_slug($slug)['seller'];

        return view('admin.seller.edit_seller', compact('seller'));
    }

    public function update_seller(Request $request, $slug)
    {
        $seller = $this->sellerService->find_by_slug($slug)['seller'];
        
        $request->validate([
            'first_name' => 'string|sometimes|max:50',
            'last_name' => 'string|sometimes|max:50',
            'profile_picture' => 'sometimes',
            'email' => 'sometimes|email|unique:sellers,email,' . $seller->id,
            'phone' => 'sometimes|unique:sellers,phone,' . $seller->id,
            'password' => 'sometimes',
            'company_name' => 'string|sometimes|max:100',
            'company_logo' => 'sometimes',
            'account_status' => 'sometimes',
            'is_approved' => 'sometimes',
        ]);

        // image work
        $req = Arr::except($request->all(),['profile_picture', 'company_logo']);
        // profile_picture
        if($request->profile_picture){
            Storage::disk('public_sellers')->delete($seller->profile_picture);
            $image = $request->profile_picture;
            $imageName = Str::random(10).'.png';
            Storage::disk('public_sellers')->put($imageName, \File::get($image));
            $req['profile_picture'] = $imageName;
        }
        // company_logo
        if($request->company_logo){
            Storage::disk('public_companies')->delete($seller->company_logo);
            $image = $request->company_logo;
            $imageName = Str::random(10).'.png';
            Storage::disk('public_companies')->put($imageName, \File::get($image));
            $req['company_logo'] = $imageName;
        }

        // password hashing
        if(isset($req['password'])){
            $req['password'] = Hash::make($req['password']);
        }
        else{
            unset($req['password']);
        }

        // update seller
        $seller = ($this->sellerService->update($req, $seller->id))['seller']['seller'];

        return $this->index();
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
