<?php

namespace App\Http\Controllers\Auth;

use App\Api\ApiResponse;
use App\Models\User\User;
use App\Utility\Generator;
use Illuminate\Http\Request;
use App\Traits\ReturnsApiResponse;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers, ReturnsApiResponse;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->response = new ApiResponse();
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'phone';
    }

    /**
     * Validates request inputs, checks against rules
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function validateLogin($request)
    {
        // Validate input using ReturnsApiResponse
        $this->validateInputs($request->all(), [
            'phone' => 'required',
            'password' => 'required'
        ]);
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        $this->response->addData($user->id, 'users', $user, ['name', 'phone', 'account_type', 'account_id', 'access'], ['donor']);

		try {
			$request->session();

			if ($user->isAdmin) {
				// Start session
				$request->session()->regenerate();
				$this->clearLoginAttempts($request);

				// Returns response
				return $this->response->ok()->withCookie(cookie()->forever('access_token', $user->access->first()->api_key));
			}
		} catch (\Throwable $e) {
			if ($e->getCode() === 0) {
				return $this->response->ok();
			}
		}

		return $this->response->ok();
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendFailedLoginResponse($request)
    {
        // Return an unauthorized response
        return $this->response->unauthorized(User::ERROR_NOT_FOUND, 'Wrong user credentials');
    }
}
