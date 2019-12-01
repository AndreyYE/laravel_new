<?php

namespace App\Http\Middleware;

use Closure;

class FieledProfile
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
        if(!$request->user()->hasFilledProfile()){
            return redirect()->route('cabinet.profile.index')->with('error','Fill your profile and verify your phone.');
        }
        return $next($request);
    }
}
