<?php

namespace App\Api;

use Carbon\Carbon;

class HTMLResponse
{
    public $response;

    /**
     * Instantiate an HTMLResponse, build and format the response
     *
     * @param $viewName  The view to return as html response
     * @param $data  Data to pass to view
     * @param $status The Response status
     * @return response
     **/
    function __construct($viewName, $viewData, $data = null, $status = 200)
    {
        $view = view($viewName, $viewData)->render();

        // Initialize $data if null
        $data = is_null($data) ? new \stdClass : $data;
        $data->contents = true;

        if (empty($viewData['contents']) || $viewData['contents']->isEmpty()) {
            // Returns the zero content view
            $view = view(explode('.', $viewName)[0].'.zero')->render();
            $data->contents = false;
        }


        $array = ['data' => $data, 'view' => $view];
        $this->response = response()->json($array, $status);
    }

    /**
     * Format the Response to comply with the API STANDARD SPECS.
     *
     * @return void
     **/
    private function formatResponse($headers = null)
    {
        $this->response->withHeaders([
            'X-Timestamp' => Carbon::now()->toDateTimeString()
        ]);

        if ($headers) {
            // format the rest
        }
    }

    /**
     * Returns the html response to the user
     *
     * @param $status The response status.
     * @return response
     **/
    public function make()
    {
        $this->formatResponse();
        return $this->response;
    }
}
