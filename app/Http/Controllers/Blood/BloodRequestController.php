<?php

namespace App\Http\Controllers\Blood;

use App\Api\ApiResponse;
use Illuminate\Http\Request;
use App\Models\Donation\Donor;
use App\Models\Blood\BloodRequest;
use App\Traits\ReturnsApiResponse;
use App\Http\Controllers\Controller;

class BloodRequestController extends Controller
{
    use ReturnsApiResponse;

    public $repository;

    // $this->repository;

    /**
     * Gets a collection of BloodRequest
     *
     * @param Request $request
     * @return App\Api\ApiResponse
     */
    public function index(Request $request)
    {
        $canSeeClosed = $request->user->isAdmin;

        // Collection
        $collection = $canSeeClosed ? BloodRequest::all() : BloodRequest::where('closed_at', NULL)->get();

        $this->response->addCollection($collection->all(), 'blood_requests', ['requester_phone', 'created_at', 'notification_sent_at', 'closed_at'], ['requester', 'location', 'blood_type', 'donations']);

        // Response
        return $this->response->ok();
    }

    /**
     * Store a blood_request resource in db
     *
     * @param Request $request
     * @return App\Api\ApiResponse
     */
    public function store(Request $request)
    {
        // Authenticated User
        $user = $request->user;

        // Validate inputs
        $this->validateInputs($request->all(), [
            'requester_location_id' => 'required',
            'blood_type_id' => 'required|max:1',
        ]);

        $isDonor = Donor::where('phone', $user->phone)->where('status', 1)->first() !== null;

        // Create request
        $bloodRequest = BloodRequest::firstOrCreate([
            'requested_by' => $user->id,
            'closed_at' => NULL
        ], [
            'requested_by' => $user->id,
            'requester_phone' => $user->phone,
            'requester_location_id' => $request->requester_location_id,
            'blood_type_id' => $request->blood_type_id,
            'by_donor' => $isDonor
        ]);

        // Donor already exists
        if (!$bloodRequest->wasRecentlyCreated) {
            return $this->response->forbidden(BloodRequest::REQUEST_PENDING, 'You already have a pending request');
        }

        // Send notification
        $this->response->addSuccessMeta('Request posted successfully');

        return $this->response->ok();
    }

    /**
     * Shows a BloodRequest resource
     *
     * @param Request $request
     * @return App\Api\ApiResponse
     */
    public function show(BloodRequest $bloodRequest)
    {
        $this->response->addData($bloodRequest->id, 'blood_requests', $bloodRequest, ['created_at', 'notification_sent_at', 'closed_at'], ['requester', 'location', 'blood_type', 'donations']);
        // Response
        return $this->response->ok();
    }

    /**
     * Shows a BloodRequest resource
     *
     * @param Request $request
     * @return App\Api\ApiResponse
     */
    public function donations(BloodRequest $bloodRequest)
    {
        $this->response->addCollection($bloodRequest->donations->all(), 'donations', ['id', 'donor_id', 'stage']);
        // Response
        return $this->response->ok();
    }
}
