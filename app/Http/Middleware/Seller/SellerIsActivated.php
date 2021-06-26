<?php

namespace App\Http\Middleware\Seller;

use Closure;
use Illuminate\Http\Request;

class SellerIsActivated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->user()->account_status === 0){
            auth()->logout();
            return response()->view('seller.auth.account_inactive');
        }
        return $next($request);
    }
}
