<?php namespace LmsApi\Middlewares;

use Closure;
use Auth;

class BasicAuth {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{		
		$user_name = base64_decode($request->getUser());
		if($user_name != \Config::get('lmsapi.apikey')) {
                $headers = array('WWW-Authenticate' => 'Basic');
                return response("API KEY NOT VALID", 401, $headers);
    }
		return $next($request);
	}

}
