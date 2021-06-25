<?php

namespace App\Http\Controllers\Seller\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/seller';

    public function __construct()
    {
        $this->middleware('guest:seller')->except('logout');
    }

    public function showLoginForm()
    {
        return view('seller.auth.login');
    }
    
    public function login(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:4'
        ]);
    
        if (Auth::guard('seller')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
    
            return redirect()->intended('/seller');
        }
        return redirect()->back()->withInput($request->only('email', 'remember'));
    }
}