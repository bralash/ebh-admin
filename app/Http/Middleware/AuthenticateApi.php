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

        if ($apiRequest->key == null) {
            return $apiRequest->noKeyResponse();
        }
        elseif (!$apiRequest->authenticated) {
            return $apiRequest->authTokenMismatch();
        } else {
            $request->access = $apiRequest->access; # App\Models\User\UserAccessKey
        }

        return $next($request);
    }
}
