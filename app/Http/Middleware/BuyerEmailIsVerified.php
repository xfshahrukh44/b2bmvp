<?php

namespace App\Http\Middleware;

use App\Models\Buyer;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;

class BuyerEmailIsVerified extends EnsureEmailIsVerified
{
  public function handle($request, Closure $next)
  {
    if (! $request->user('buyer') || ($request->user('buyer') instanceof Buyer && ! $request->user('buyer')->hasVerifiedEmail())) {
        return $request->expectsJson()
            ? abort(403, 'Your email address is not verified.')
            : Redirect::route('buyer.verification.notice');
        }
        return $next($request);
    }
}