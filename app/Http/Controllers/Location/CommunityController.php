<?php

namespace App\Http\Controllers\Location;

use App\Api\ApiResponse;
use Illuminate\Http\Request;
use App\Models\Location\Community;
use App\Traits\ReturnsApiResponse;
use App\Http\Controllers\Controller;

class CommunityController extends Controller
{
    use ReturnsApiResponse;

    private $repo;

    public function construct()
    {
        $this->repo = Community::class;
    }

    /**
     * Returns a collection of all communities
     *
     * @return App\Api\ApiResponse
     */
    public function index()
    {
        $paginated = (object) $this->repo::paginate(50)->toArray();

        // Add links to response
        $this->addPaginationLinks($paginated);

        // Add meta to response
        $this->addPaginationMeta($paginated);

        // Add data collection to response
        $this->response->addCollection($paginated->data, 'communities', ['id', 'name', 'region', 'district', 'gps_address']);

        return $this->response->ok();
    }

    /**
     * Stores a
     *
     * @param Request $request
     * @return App\Api\ApiResponse
     */
    public function store(Request $request)
    {
        if (!$request->user->isAdmin) {
            return $this->response->forbidden();
        }

        // Validation
        $this->validateInputs($request->all(), [
            'name' => 'required',
            'region' => 'required',
        ]);

        // Create or get first
        $community = $this->repo::firstOrCreate([
            'name' => $request->name,
            'region' => $request->region,
        ], $request->all());

        // Community exists
        if (!$community->wasRecentlyCreated) {
            $this->response->addError([
                'title' => 'Community exists already',
                'detail' => 'Please update instead',
                'status' => ApiResponse::UNPROCESSABLE_ENTITY,
                'code' => $this->repo::ERROR_EXISTS,
            ]);

            return $this->response->make('UNPROCESSABLE_ENTITY');
        }

        $this->response->addData($community->id, 'communities', $community, ['name', 'region', 'district', 'gps_address', 'created_at']);

        return $this->response->ok();
    }
    //
}
