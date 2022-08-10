<?php namespace App\Http\Middleware;

use Closure;
use Auth;


class InitialSetup {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (!Auth::user()->initial_setup_completed) {
			return Redirect::action('SetupController@index');
		}
		return $next($request);
	}

}
