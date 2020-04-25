<?php

namespace App\Http\Controllers\Location;

use App\Community;
use Illuminate\Http\Request;
use App\Traits\ReturnsApiResponse;
use App\Http\Controllers\Controller;

class CommunityController extends Controller
{
    use ReturnsApiResponse;

    /**
     * Returns a collection of all communities
     *
     * @return App\Api\ApiResponse
     */
    public function index()
    {
        $paginated = (object) Community::paginate(15)->toArray();

        // Add links to response
        $this->addPaginationLinks($paginated);

        // Add meta to response
        $this->addPaginationMeta($paginated);

        // Add data collection to response
        $this->response->addCollection($paginated->data, 'communities', ['id', 'name', 'region']);

        return $this->response->ok();
    }
    //
}
