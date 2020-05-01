<?php

namespace App\Http\Controllers\Donation;

use App\Api\ApiResponse;
use App\Utility\Generator;
use Illuminate\Http\Request;
use App\Models\Donation\Donation;
use App\Traits\ReturnsApiResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DonationController extends Controller
{
    use ReturnsApiResponse;

    private $repo;

    public function construct()
    {
        $this->repo = Donation::class;
    }

    /**
     * Returns a collection of donation resources
     *
     * @param Request $request
     * @return App\Api\ApiResponse
     */
    public function index(Request $request)
    {
        if (!$request->user->isAdmin) {
            return $this->response->forbidden();
        }

        // Search donations by blood group + location
        $params = $request->all();

        if (count($params)) {
            // Filter for searchable columns
            $queries = \array_filter($params, function($key) {
                return in_array($key, ['donation_type', 'event_id', 'donor_id', 'stage', 'donation_uid']);
            }, ARRAY_FILTER_USE_KEY);

            $whereClauses = array();

            // Construct where clause arrays
            \array_walk($queries, function($param, $key) use (&$whereClauses) {
                \array_push($whereClauses, [$key, '=', $param]);
            });

            $paginated = (object) $this->repo::where($whereClauses)->paginate(20)->toArray();

            // Add searching columns to meta
            $this->response->addMeta([
                'search_columns' => array_keys($queries)
            ]);
        }
        else {
            $paginated = (object) $this->repo::paginate(20)->toArray();
        }

        // Add links to response
        $this->addPaginationLinks($paginated);

        // Add meta to response
        $this->addPaginationMeta($paginated);

        // Add data collection to response
        $this->response
            ->addCollection(
                $paginated->data,
                'donations',
                ['id', 'donation_type', 'event_id', 'volume', 'stage', 'created_at'],
                ['donor']
            );

        return $this->response->ok();
    }

    /**
     * Stores a Donation resource
     *
     * @param Request $request
     * @return App\Api\ApiResponse
     */
    public function store(Request $request)
    {
        if (!$request->user->donor) {
            return $this->response->forbidden('You are not a donor');
        }

        // Validation
        $this->validateInputs($request->all(), [
            'donation_type' => 'required',
            'event_id' => 'required',
        ]);

        DB::beginTransaction();

        // Create or get first
        $donation = $this->repo::firstOrCreate([
            'donation_type' => $request->donation_type,
            'event_id' => $request->event_id,
            'donor_id' => $request->user->donor->id,
        ], [
            'donation_type' => $request->donation_type,
            'event_id' => $request->event_id,
            'donor_id' => $request->user->donor->id,
            'donation_uid' => Generator::generateCode(5),
            'volume' => 0
        ]);

        DB::commit();

        // Donation exists
        if (!$donation->wasRecentlyCreated) {
            $this->response->addError([
                'title' => 'Donation exists already',
                'detail' => 'Please update instead',
                'status' => ApiResponse::UNPROCESSABLE_ENTITY,
                'code' => Donation::ERROR_EXISTS,
            ]);

            return $this->response->make('UNPROCESSABLE_ENTITY');
        }

        $this->response->addSuccessMeta('Donation added successfully');

        return $this->response->ok();
    }

    /**
     * Updates a Donation resource
     *
     * @param Request $request
     * @return App\Api\ApiResponse
     */
    public function update(Request $request, Donation $donation)
    {
        if (!$request->user->donor) {
            return $this->response->forbidden('You are not a donor');
        }

        $params = $request->all();

        // Filter for searchable columns
        $queries = \array_filter($params, function($key) {
            return in_array($key, ['volume', 'stage']);
        }, ARRAY_FILTER_USE_KEY);

        DB::beginTransaction();

        // Update query
        $updated = $donation->update($queries);

        DB::commit();

        // Add success meta
        $this->response->addSuccessMeta('Donation details updated successfully');

        return $this->response->ok();
    }
}
