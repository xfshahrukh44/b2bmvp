<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Spatie\Permission\Models\Role;

class LoginController extends Controller
{
    // use AuthenticatesUsers;

    // protected $redirectTo = '/admin';

    public function __construct()
    {
        $this->middleware('guest:admin')->except('adminLogout');
    }

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }
    
    public function login(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:4'
        ]);
    
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            // return redirect()->intended('/admin');
            return redirect('/admin');
        }
        return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function redirectTo(){
        // dd($request);
        if ($user->hasRole('admin')) {
            return redirect('/dashboard');
        }
    }

    public function adminLogout(Request $request)
    {
        // dd($request->all());
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        return redirect('/admin/login');
    }


}