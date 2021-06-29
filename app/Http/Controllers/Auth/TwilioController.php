<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Twilio\Rest\Client;

class TwilioController extends Controller
{
    // twilio | OTP
    protected function sendOTPCode(Request $request)
    {
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio = new Client($twilio_sid, $token);
        $twilio->verify->v2->services($twilio_verify_sid)
            ->verifications
            ->create('+92' . $request['phone'], "sms");
        return true;
    }

    protected function verifyOTPCode(Request $request)
    {
        $data = $request->validate([
            'otp' => ['required', 'numeric'],
            'phone' => ['required', 'string'],
        ]);

        /* Get credentials from .env */
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio = new Client($twilio_sid, $token);
        $verification = $twilio->verify->v2->services($twilio_verify_sid)
            ->verificationChecks
            ->create($data['otp'], array('to' => '+92' . $data['phone']));
        if ($verification->valid) {
            return 1;
        }
        return 0;
    }
}
