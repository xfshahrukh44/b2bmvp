<?php

namespace App\Http\Middleware\Seller;

use Closure;
use Illuminate\Http\Request;

class SellerIsApproved
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
        if($request->user()->is_approved === NULL){
            auth()->logout();
            return response()->view('seller.auth.pending_approval');
        }
        if($request->user()->is_approved === 0){
            auth()->logout();
            return response()->view('seller.auth.account_rejected');
        }
        return $next($request);
    }
}
