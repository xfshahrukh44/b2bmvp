<?php

namespace App\Http\Controllers\Seller\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use Auth;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    // use Password;
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/seller';

    protected function guard()
    {
        return Auth::guard('seller');
    }

    protected function broker()
    {
        return Password::broker('sellers');
    }

    public function showResetForm(Request $request, $token = null)
    {   
        return view('seller.auth.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:4',
        ];
    }
}
