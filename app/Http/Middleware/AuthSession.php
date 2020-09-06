<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;

class AuthSession 
{
	
	public function handle($request, Closure $next)
	{
		if (!auth::guard('user')->check()) {

			return redirect('/login');
		}

		return $next($request);
	}
}

?>