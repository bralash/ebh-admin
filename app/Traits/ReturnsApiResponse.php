<?php

namespace App\Traits;

use App\Api\ApiResponse;
use App\Api\ValidationException;

trait ReturnsApiResponse
{
    /**
     * The validator instance.
     *
     * @var \App\Api\ApiResponse
     */
    private $response;

    /**
     * Create a new App\Api\ApiResponse as a member variable
     *
     * @return void
     */
    public function __construct()
    {
        $this->response = new ApiResponse();

        if (method_exists($this, 'construct')) {
            $this->construct();
        }
    }

    public function addPaginationLinks($paginated)
    {
        $this->response->addLinks([
            'first' => $paginated->first_page_url,
            'last' => $paginated->last_page_url,
            'next' => $paginated->next_page_url,
            'prev' => $paginated->prev_page_url,
        ]);
    }

    public function addPaginationMeta($paginated)
    {
        // Add metadata to response
        $this->response->addMeta([
            'from' => $paginated->from,
            'last_page' => $paginated->last_page,
            'per_page' => $paginated->per_page,
            'to' => $paginated->to,
            'total' => $paginated->total,
        ]);
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
