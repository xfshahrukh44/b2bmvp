<?php

namespace App\Http\Controllers\Seller\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Seller;
use App\Models\Province;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest:seller');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string'],
            'city_id' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:sellers'],
            'phone' => ['required', 'string', 'max:13'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
        ]);
    }

    public function showRegisterForm()
    {
        $provinces = Province::all();
        return view('seller.auth.register', compact('provinces'));
    }

    protected function create(Request $request)
    {
        // dd($request->all());
        $this->validator($request->all())->validate();
        $seller = Seller::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'company_name' => $request['company_name'],
            'type' => $request['type'],
            'city_id' => $request['city_id'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'password' => Hash::make($request['password']),
            'is_verified' => 1,
        ]);
        event(new Registered($seller));
        $seller->assignRole('seller');
        // return redirect()->intended('/seller/login');
        return redirect('/seller/login');
    }
}
