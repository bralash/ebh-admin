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

	private function exist()
	{
		$this->response->addError([
			'title' => 'User exists already',
			'detail' => 'This user is already registered',
			'status' => ApiResponse::UNPROCESSABLE_ENTITY,
			'code' => User::ERROR_EXISTS,
		]);

		return $this->response->make('UNPROCESSABLE_ENTITY');
	}
	/**
     * Fetch all donors
     *
     * @param Request $request
     * @return App\Api\ApiResponse
     */
	public function index()
	{
		$paginated = (object) User::paginate(50)->toArray();

		// Add links to response
		$this->addPaginationLinks($paginated);

		// Add meta to response
		$this->addPaginationMeta($paginated);

		// Add data collection to response
		$this->response->addCollection($paginated->data, 'users', ['id', 'name', 'phone', 'user_type']);

		return $this->response->ok();
	}

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
					return self::exist();
                    break;

                default:
                    $this->response->addMeta(['success' => false, 'message' => 'Something went wrong']);
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

	public function update(Request $request, User $user)
	{
		if (!$request->user->isAdmin)
			return $this->response->forbidden('You can\'t perform this action');

		try {
			$user->update([
				'name' => $request->name,
				'phone' => $request->phone,
				'password' => bcrypt($request->password)
			]);
		} catch (\Illuminate\Database\QueryException  $e) {
			switch ($e->getCode()) {
				case '23000':
					return self::exist();
                    break;

				default:
					$this->response->addMeta(['success' => false, 'message' => 'Something went wrong']);
					$this->response->bad();
					break;
			}
		}

		$this->response->addSuccessMeta('User updated successfully!');
		return $this->response->ok();
	}

	/**
	 * Delete resource from db
	 *
	 * @param Request $request
	 * @param User $user
	 * @return ApiResponse
	 */
	public function destroy(Request $request, User $user)
	{
		if ($user->delete()) {
			$this->response->addSuccessMeta('User deleted successfully!');
			return $this->response->ok();
		}
		else {
			return $this->response->make('SERVICE_UNAVAILABLE');
		}
	}
}
