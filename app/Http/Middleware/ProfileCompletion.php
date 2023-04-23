<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileCompletion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!empty(Auth::user()->email) && empty(Auth::user()->mobile) && empty(Auth::user()->email_verified_at))
        {
            return redirect()->route('home.sales-proccess.profile-completion');
        }
        if(!empty(Auth::user()->mobile) && empty(Auth::user()->email) && empty(Auth::user()->mobile_verified_at))
        {
            return redirect()->route('home.sales-proccess.profile-completion');
        }
        if(empty(Auth::user()->first_name) || empty(Auth::user()->last_name) && empty(Auth::user()->natioanl_code))
        {
            return redirect()->route('home.sales-proccess.profile-completion');
        }
        return $next($request);
    }
}
