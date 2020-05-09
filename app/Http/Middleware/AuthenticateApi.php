<?php

namespace App\Http\Middleware;

use Closure;
use App\Api\ApiRequest;
use Illuminate\Support\Facades\Crypt;
use App\Http\Middleware\VerifyCsrfToken;

class AuthenticateApi
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
        // If API request is not auth request
        if (!$request->route()->named('auth.api') && !$request->route()->named('user.post.api')) {

			// Check for bearer token
			$key = $request->bearerToken();

			if ($key == null) {
				$key = $request->cookie('access_token');
				$key = $key ? Crypt::decrypt($key, false) : null;

				if ($key !== null) {

					$request->session();
				}
			}

			$apiRequest = new ApiRequest($request, $key);

            // API key not provided
            if ($apiRequest->key == null) {
                return $apiRequest->noKeyResponse();
            }
            // API key not found
            elseif (!$apiRequest->authenticated) {
                return $apiRequest->authTokenMismatch();
            } else {
                $request->access = $apiRequest->access; # App\Models\User\UserAccessKey
                $request->user = $apiRequest->access->user; # App\Models\User\User
            }
        }

        return $next($request);
    }
}
