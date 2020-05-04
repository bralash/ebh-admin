<?php

namespace App\Http\Controllers\Donation;

use App\Api\ApiResponse;
use App\Models\User\User;
use Illuminate\Http\Request;
use App\Models\Donation\Donor;
use App\Traits\ReturnsApiResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class DonorController extends Controller
{
    use ReturnsApiResponse;

    /**
     * Fetch all donors
     *
     * @param Request $request
     * @return App\Api\ApiResponse
     */
    public function index(Request $request)
    {
        // Search donors by blood group + location
        $params = $request->all();

        if (count($params)) {
            // Filter for searchable columns
            $queries = \array_filter($params, function($key) {
                return in_array($key, ['community_id', 'blood_type_id', 'status']);
            }, ARRAY_FILTER_USE_KEY);

            $whereClauses = array();

            // Construct where clause arrays
            \array_walk($queries, function($param, $key) use (&$whereClauses) {
                \array_push($whereClauses, [$key, '=', $param]);
            });

            $paginated = (object) Donor::where($whereClauses)->paginate(50)->toArray();

            // Add searching columns to meta
            $this->response->addMeta([
                'search_columns' => array_keys($queries)
            ]);
        }
        else {
            $paginated = (object) Donor::paginate(50)->toArray();
        }

        // Add links to response
        $this->addPaginationLinks($paginated);

        // Add meta to response
        $this->addPaginationMeta($paginated);

        // Add data collection to response
        $this->response->addCollection($paginated->data, 'donors', ['id', 'firstname', 'lastname'], ['badge', 'blood_type', 'community']);

        return $this->response->ok();
    }

    /**
     * Store a donor resource in db
     *
     * @param Request $request
     * @return App\Api\ApiResponse
     */
    public function store(Request $request)
    {
        // Request payload
        $inputs = $request->all();

        // Add phone to payload
        $inputs = array_merge($inputs, ['phone' => $request->user->phone, 'badge_id' => 1]);

        // Validate inputs
        $this->validateInputs($inputs, [
            'firstname' => 'required',
            'lastname' => 'required',
            'phone' => 'required|min:10',
            'community_id' => 'required',
            'date_of_birth' => 'required|date_format:Y-m-d',
            'blood_type_id' => 'required|max:1',
        ]);

        DB::beginTransaction();

        // Find or create new
        $donor = Donor::firstOrCreate([ 'phone' => $inputs['phone']  ], $inputs);

        // Donor already exists
        if (!$donor->wasRecentlyCreated) {
            $this->response->addError([
                'title' => 'Donor exists already',
                'detail' => 'This user is already registered as a donor',
                'status' => ApiResponse::UNPROCESSABLE_ENTITY,
                'code' => Donor::ERROR_EXISTS,
            ]);

            return $this->response->make('UNPROCESSABLE_ENTITY');
        }

        // Success response
        $this->response->addData($donor->id, 'donors', $donor, ['firstname', 'lastname', 'phone']);

        DB::commit();

        return $this->response->created();
    }

    /**
     * Returns a single donor resource
     *
     * @param Request $request
     * @return App\Api\ApiResponse
     */
    public function show(Request $request, Donor $donor)
    {
        // Add response data
        $this->response->addData($donor->id, 'donors', $donor, ['firstname', 'lastname', 'phone'], ['badge', 'blood_type', 'community']);

        // Return response
        return $this->response->ok();
    }
}
