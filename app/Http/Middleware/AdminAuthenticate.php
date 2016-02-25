<?php namespace Kneu\Survey\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminAuthenticate {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle(Request $request, Closure $next)
	{
		if( config('admin.login') === $request->getUser() && config('admin.password') === $request->getPassword() ) {
			return $next($request);
		}

		return $this->getBasicResponse();
	}

	protected function getBasicResponse()
	{
		$headers = ['WWW-Authenticate' => 'Basic'];

		return new Response('Invalid credentials.', 401, $headers);
	}
}
