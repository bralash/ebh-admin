<?php

namespace App\Http\Controllers\Donation;

use App\Api\ApiResponse;
use App\Models\User\User;
use Illuminate\Http\Request;
use App\Models\Donation\Donor;
use App\Traits\ReturnsApiResponse;
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
                return in_array($key, ['community_id', 'blood_type_id']);
            }, ARRAY_FILTER_USE_KEY);

            $whereClauses = array();

            // Construct where clause arrays
            \array_walk($queries, function($param, $key) use (&$whereClauses) {
            \array_push($whereClauses, [$key, '=', $param]);
            });

            $paginated = (object) Donor::where($whereClauses)->paginate(15)->toArray();

            // Add searching columns to meta
            $this->response->addMeta([
                'search_columns' => array_keys($queries)
            ]);

        }
        else {
            $paginated = (object) Donor::paginate(15)->toArray();
        }

        // Add links to response
        $this->response->addLinks([
            'first' => $paginated->first_page_url,
            'last' => $paginated->last_page_url,
            'next' => $paginated->next_page_url,
            'prev' => $paginated->prev_page_url,
        ]);

        // Add metadata to response
        $this->response->addMeta([
            'from' => $paginated->from,
            'last_page' => $paginated->last_page,
            'per_page' => $paginated->per_page,
            'to' => $paginated->to,
            'total' => $paginated->total,
        ]);

        // Add data collection to response
        $this->response->addCollection($paginated->data, ['id', 'firstname', 'lastname']);

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
        if (\array_search($request->user->account_type, [User::TYPE_ADMIN]) === false) {
            return $this->response->forbidden(Donor::ERROR_ACCESS_DENIED);
        }

        // Validate inputs
        $this->validateInputs($request->all(), [
            'firstname' => 'required',
            'lastname' => 'required',
            'phone' => 'required|min:10',
            'community_id' => 'required',
            'date_of_birth' => 'required|date_format:Y-m-d',
            'blood_type_id' => 'required|max:1',
        ]);

        // Payload
        $inputs = array_merge($request->all(), ['badge_id' => 1]);

        // Find or create new
        $donor = Donor::firstOrCreate([ 'phone' => $request->input('phone')  ], $inputs);

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

        return $this->response->created();
    }
    //
}
