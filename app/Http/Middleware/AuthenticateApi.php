<?php

namespace App\Http\Middleware;

use Closure;
use App\Api\ApiRequest;

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
        $apiRequest = new ApiRequest($request);

        // If API request is not auth request
        if (!$request->route()->named('auth.api') && !$request->route()->named('user.post.api')) {
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
