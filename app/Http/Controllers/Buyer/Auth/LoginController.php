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

    protected $redirectTo = '/buyer';

    public function __construct()
    {
        $this->middleware('guest:buyer')->except('buyerLogout');
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
    
            // return redirect()->intended('/');
            return redirect('/');
        }
        return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function buyerLogout(Request $request)
    {
        // dd($request->all());
        Auth::guard('buyer')->logout();

        $request->session()->invalidate();

        return redirect('/login');
    }
}