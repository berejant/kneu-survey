<?php namespace Kneu\Survey\Http\Middleware;

use Closure;

class StudentAuth {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$route = $request->route();

		/** @var Student $student */
		$student = $route->getParameter('student');
		$secret = $route->getParameter('secret');

		if( !$student || $student->getSecret() !== $secret ) {
			abort(404);
		}

		return $next($request);
	}

}
