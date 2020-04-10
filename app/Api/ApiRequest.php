<?php

namespace App\Api;

use App\Api\ApiError;
use App\Api\ApiResponse;
use Illuminate\Http\Request;
use App\Models\User\UserAccessKey;
use Illuminate\Support\Facades\Crypt;
use App\Models\User\UserAccessKey as AccessToken;

class ApiRequest
{
    private $request;
    private $response;

    public $authenticated;
    public $user;
    public $platform;
    public $key;

    /**
     * Create a new ApiResponse instance as a member variable, checks API key for validity
     *
     * @param Request $request
     * @return void
     */
    function __construct(Request $request)
    {
        $this->request = $request;
        $this->response = new ApiResponse();
        $this->platform = $this->request->header('X-Platform');

        // Check for bearer token
        $key = $this->request->bearerToken();

        if ($key == null) {
            $key = $this->request->cookie('access_token');
            $key = $key ? Crypt::decrypt($key) : null;

            if ($key == null) {
                return;
            }
        }

        $this->key = $key;
        $api = $this->check($this->key);

        $this->authenticated = $api->passed;
        $this->access = $api->access;
    }

    /**
     * Check if attached auth token is valid and associated with a user
     *
     * @param string  $key  The access token
     *
     * @return stdClass
     **/
    private function check($key)
    {
        $access = AccessToken::attempt($key);

        // Construct object
        $std = new \stdClass();
        $std->passed = false;
        $std->access = null;

        if ($access) {
            $std->passed = true;
            $std->access = $access;
        }

        return $std;
    }

    /**
     * Return an UNAUTHORISED HTTP response
     *
     * @return Response
     */
    public function noKeyResponse()
    {
        // Adds error then returns response
        return $this->response->unauthorized(ApiError::API_KEY_NULL, "No API key provided");
    }

    /**
     * Return a UNAUTHORISED HTTP response
     *
     * @return Response
     **/
    public function authTokenMismatch()
    {
        // Adds error then returns response
        return $this->response->unauthorized(ApiError::API_KEY_MISMATCH, "Provided key did'nt match any valid key");
    }
}
