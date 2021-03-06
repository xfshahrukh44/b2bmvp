<?php

namespace App\Http\Controllers\Buyer\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Buyer;
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
        $this->middleware('guest:buyer');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:buyers'],
            'phone' => ['required', 'string', 'max:13'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
        ]);
    }

    public function showRegisterForm()
    {
        return view('buyer.auth.register');
    }

    protected function create(Request $request)
    {
        $this->validator($request->all())->validate();
        $buyer = Buyer::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'password' => Hash::make($request['password']),
            'is_verified' => 1,
        ]);
        event(new Registered($buyer));
        $buyer->assignRole('buyer');
        // return redirect()->intended('/login');
        return redirect('/login');
    }
}
