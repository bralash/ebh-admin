<?php

namespace App\Traits;

use App\Api\ApiResponse;
use App\Api\ValidationException;

trait ReturnsApiResponse
{
    private $response;

    /**
     * Create a new App\Api\ApiResponse as a member variable
     *
     * @return void
     */
    public function __construct()
    {
        $this->response = new ApiResponse();
    }

    /**
     * Validates request inputs, checks against rules
     *
     * @param array $inputs
     * @param array $rules
     * @return void
     */
    private function validateInputs(array $inputs, array $rules)
    {
        $validator = validator($inputs, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator, new ApiResponse());
        }
    }
}
