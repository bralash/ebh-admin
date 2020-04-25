<?php

namespace App\Http\Controllers\Blood;

use Illuminate\Http\Request;
use App\Models\Blood\BloodType;
use App\Traits\ReturnsApiResponse;
use App\Http\Controllers\Controller;

class BloodTypeController extends Controller
{
    use ReturnsApiResponse;

    /**
     * Returns a collection of all blood types
     *
     * @return App\Api\ApiResponse
     */
    public function index()
    {
        $bloodTypes = BloodType::all();

        // Add data collection to response
        $this->response->addCollection($bloodTypes->toArray(), 'blood_types', ['id', 'name', 'code']);

        return $this->response->ok();
    }
}
