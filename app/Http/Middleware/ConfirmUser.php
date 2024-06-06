<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class ConfirmUser
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
        if (Auth::user()->confirm_status == false || Auth::user()->banned == 1) {
            return redirect(route('main'))->with('message', Lang::get('welcome.unconfirm_user'));
        }

        return $next($request);
    }
}
