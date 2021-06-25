<?php

namespace App\Http\Controllers\Buyer\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest:buyer')->except('logout');
    }

    public function showLoginForm()
    {
        return view('buyer.auth.login');
    }
    
    public function login(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:4'
        ]);
    
        if (Auth::guard('buyer')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
    
            return redirect()->intended('/buyer');
        }
        return redirect()->back()->withInput($request->only('email', 'remember'));
    }
}