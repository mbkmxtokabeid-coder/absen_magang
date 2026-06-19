<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Profile
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
    if (auth()->user() == null || auth()->user()->role == 2) {
      return redirect('/');
    } else if(auth()->user()->role != 2) {
      return $next($request);
    }
  }
}
