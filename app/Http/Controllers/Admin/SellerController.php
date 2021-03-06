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
    
    protected $sellerService;

    public function __construct(SellerService $sellerService)
    {
        $this->sellerService = $sellerService;
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
        if(!$request->has('search')){
            $sellers = $this->sellerService->paginate(10);
        }
        else{
            $sellers = $this->search_sellers($request->all());
        }
        
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
            'profile_picture' => 'mimes:jpeg,jpg,png,svg|sometimes|max:5125',
            'email' => 'required|email|unique:sellers',
            'phone' => 'required|regex:/^[0-9]+$/|unique:sellers',
            'password' => 'required|string|min:4|confirmed',
            'company_name' => 'string|required|max:100',
            'company_address' => 'string|required|max:100',
            'company_logo' => 'mimes:jpeg,jpg,png,svg|sometimes|max:5125',
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

        // phone number
        if(isset($req['phone'])){
            $req['phone'] = '+92' . $req['phone'];
        }

        // email_verified_at
        $req['email_verified_at'] = Carbon::now();

        // create seller
        $seller = ($this->sellerService->create($req))['seller']['seller'];

        // assign seller role
        $seller->assignRole('seller');
        
        // fire registration event
        event(new Registered($seller));

        return redirect()->route('seller_index')->with('success', 'Seller added.');
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
            'profile_picture' => 'mimes:jpeg,jpg,png,svg|sometimes|max:5125',
            'email' => 'sometimes|email|unique:sellers,email,' . $seller->id,
            'phone' => 'sometimes|regex:/^[0-9]+$/|unique:sellers,phone,' . $seller->id,
            'password' => 'nullable|string|min:4|confirmed',
            'company_name' => 'string|sometimes|max:100',
            'company_address' => 'string|sometimes|max:100',
            'company_logo' => 'mimes:jpeg,jpg,png,svg|sometimes|max:5125',
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

        // phone number
        if(isset($req['phone'])){
            $req['phone'] = '+92' . $req['phone'];
        }

        // update seller
        $seller = ($this->sellerService->update($req, $seller->id))['seller']['seller'];

        return redirect()->route('seller_index')->with('success', 'Seller updated.');
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

    public function search_sellers($query)
    {
        $sellers = $this->sellerService->search_sellers($query, $pagination = 10);
        
        return $sellers;
    }
}
