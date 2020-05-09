<?php

namespace App\Http\Controllers\User;

use ApiResponse;
use App\Models\User\User;
use Illuminate\Http\Request;
use App\Models\User\UserAccessKey as Access;
use App\Traits\ReturnsApiResponse;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    use ReturnsApiResponse;

    public function store(Request $request) {
        // Validate inputs
        $this->validateInputs($request->all(), [
            'name' => 'required:min:3',
            'phone' => 'required|size:10',
            'password' => 'required|min:6|not_in:password',
        ]);

        // Payload
        $inputs = $request->all();
        // $accountDataIncluded = sizeof(\array_keys($inputs, ['account_id', 'account_type'])) > 0;

        $inputs = array_merge($inputs, ['account_id' => 1, 'account_type' => User::TYPE_GENERAL]);

        // Password encryption
        $inputs['password'] = bcrypt($inputs['password']);

        try {
            // Attempt creating user
			$user = User::create($inputs);

			// Add User Access
			Access::create([
				'user_id' => $user->id,
				'api_key' => Access::new()
			]);

            // Return Response
            $this->response->addData($user->id, 'users', $user, ['name', 'phone', 'created_at']);

            return $this->response->created();
        }
        catch (\Illuminate\Database\QueryException $e) {
            // Let's see what went wrong
            switch ($e->getCode()) {
                case '23000':
                    $this->response->addError([
                        'title' => 'User exists already',
                        'detail' => 'This user is already registered',
                        'status' => ApiResponse::UNPROCESSABLE_ENTITY,
                        'code' => User::ERROR_EXISTS,
                    ]);

                    return $this->response->make('UNPROCESSABLE_ENTITY');
                    break;

                default:
                    $this->response->addMeta(['success' => false]);
                    $this->response->bad();

                break;
            }
        }
	}

	public function show(Request $request, User $user)
	{
		if (!$request->user->isAdmin) {
			if ($request->user->id != $user->id) {
				return $this->response->forbidden('You can\'t view this user');
			}
		}

        $this->response->addData($user->id, 'users', $user, ['name', 'phone', 'account_type', 'account_id', 'access'], ['donor']);
		return $this->response->ok();
	}
}
