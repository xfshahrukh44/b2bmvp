<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class EmailVerificationController extends Controller
{
    protected function showVerificationNotice()
    {
        return view('auth.verify');
    }

    protected function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return redirect('/home');
    }

    protected function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    }
}
