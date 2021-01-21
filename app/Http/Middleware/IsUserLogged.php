<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\users;

class IsUserLogged
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
        if (!isset($_COOKIE["userID"]) || !users::where("userID",$_COOKIE["userID"])->first()) {
            return redirect('giris-yap');
        }

        return $next($request);
    }
}
