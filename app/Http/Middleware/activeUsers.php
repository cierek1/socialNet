<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Carbon\Carbon;
use Cache;

class activeUsers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if( Auth::check() ) {
            $expireTime = Carbon::now()->addMinutes(2);
            Cache::put('active-user' . Auth::user()->id , true, $expireTime);
        }

        return $next($request);
    }
}
