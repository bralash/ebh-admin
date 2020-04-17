<?php

namespace App\Api;

use App\Api\Response;
use App\Api\ApiError;

class ApiResponse extends Response
{
    public $data;
    public $errors;
    public $meta;
    public $view;
    public $links;

    function __construct()
    {
        $this->response = response();

        $this->errors = array();
        $this->meta = new \stdClass();
        $this->links = new \stdClass();
    }

    /**
     * Returns a response to the client
     *
     * @param $status The response status.
     * @return response
     **/
    public function make(string $status = 'BAD_REQUEST')
    {
        $this->buildResponse(true, constant(self::class."::$status"));
        return $this->response;
    }

    /**
     * Adds an Error Object to the [errors] property. Array can contain a mixture of the following as keys
     * id, status, code, title, detail
     *
     * @param array $error The error array
     *
     * @return void
     **/
    public function addError(array $error)
    {
        array_push($this->errors, (object) $error);
    }

    /**
     * Adds [metadata] to the response
     *
     * @param array $data The data to add.
     * @return void
     **/
    public function addMeta(array $data)
    {
        foreach ($data as $key => $value) {
            $this->meta->{$key} = $value;
        }
    }

    /**
     * Adds a view/html content to the response
     *
     * @param string $viewName The name of the view to return
     * @param mixed $viewData Data to pass to view
     *
     * @return void
     **/
    public function addHTML($viewName, $viewData)
    {
        $this->addMeta([
            'view' => view($viewName, $viewData)->render()
        ]);
    }

    /**
     * Adds data for a particular resource to the API response
     *
     * @param integer  $id     ID of the resource.
     * @param string   $type   The resource type.
     * @param array    $props  Set of attributes and values of the target resource to serialize.
     *
     * @return void
     */
    public function addData($id = null, $type, $resource, $props)
    {
        $data = new \stdClass();

        # Set the id if and only if its available
        if ($id !== null) {
            $data->id = $id;
        }

        $data->type = $type;
        $data->attributes = new \stdClass();

        foreach ($props as $key => $prop) {
            $data->attributes->{$prop} = $resource->{$prop};
        }

        $this->data = $data;
    }

    /**
     * Sets data member to a collection
     *
     * @param array $collection
     * @return void
     */
    public function addCollection($collection)
    {
        $this->data = $collection;
    }

    /**
     * Adds links to the links member
     *
     * @param array $links
     * @return void
     */
    public function addLinks($links)
    {
        foreach ($links as $key => $value) {
            $this->links->{$key} = $value;
        }
    }

    /**
     * Adds a custom data object to response data property
     *
     * @param mixed $data The data object to add
     * @return void
     */
    public function addCustomData($data)
    {
        $this->data = \array_merge($this->data, $data);
    }

    /**
     * Adds metadata with success=true to the response
     *
     * @param string $message Response message
     * @return void
     **/
    public function addSuccessMeta($message)
    {
        $this->addMeta([
            'success' => true,
            'message' => $message,
        ]);
    }

    /**
     * Constructs the API response given the data and status
     *
     * @param bool $data  Does this response contain data
     * @param string $status Status Code to send
     *
     * @return void
     **/
    protected function buildResponse($data, $status)
    {
        // Construct if there is data to return
        if ($data) {
            // Properties array
            $propsArray = get_object_vars($this);

            if (count($this->errors) > 0 || is_null($this->data)) {
                // Cannot return data with errors, unset data
                unset($propsArray['data']);
            }

            $arrayMems = ['errors', 'links', 'meta'];

            // Remove empty members
            array_walk($arrayMems, function($item) use (&$propsArray) {
                // Get object vars as array, this tells if object has members
                $counter = ($this->{$item} instanceof \stdClass) ? get_object_vars($this->{$item}) : $this->{$item};

                if (count($counter) == 0) {
                    unset($propsArray[$item]); // Cannot return empty members, unset
                }
            });

            // Filter through properties for the properties in provided [To be used as response payload]
            $array = array_filter($propsArray, function ($key) {
                return in_array($key, ['meta', 'errors', 'data', 'links']);
            }, ARRAY_FILTER_USE_KEY);
        } else {
            $array = [];
        }

        $this->response = $this->response->json($array, $status);
        $this->formatResponse();
    }

    /**
     * Formats the Response to comply with the API STANDARD SPECS.
     *
     * @return void
     **/
    protected function formatResponse()
    {
        // $this->response->withHeaders(['Content-Type' => 'vnd.api+json']);
        $this->response->withHeaders(['Content-Type' => 'application/json']);
    }

    /**
     * Returns CREATED STATUS
     *
     * @return response
     **/
    public function created()
    {
        return $this->make('CREATED');
    }

    /**
     * Returns UNAUTHORIZED STATUS response
     *
     * @return Response
     **/
    public function unauthorized($code, $message = 'Authentication needed to perform action')
    {
        $this->addError([
            'title' => 'Unauthorized',
            'detail' => $message,
            'status' => self::UNAUTHORIZED,
            'code' => $code,
        ]);

        return $this->make('UNAUTHORIZED');
    }

    /**
     * Returns NOT_FOUND STATUS response
     *
     * @return \Illuminate\Http\Response
     */
    public function notFound($code, $message = 'The record was not found') {
        $this->addError([
            'title' => 'Not Found',
            'detail' => $message,
            'status' => self::NOT_FOUND,
            'code' => $code,
        ]);

        return $this->make('NOT_FOUND');
    }

    /**
     * Returns a FORBIDDEN STATUS response
     *
     * @return \Illuminate\Http\Response
     */
    public function forbidden($code, $message = 'You are allowed to perform this action') {
        $this->addError([
            'title' => 'Forbidden',
            'detail' => $message,
            'status' => self::FORBIDDEN,
            'code' => $code,
        ]);

        return $this->make('FORBIDDEN');
    }

    /**
     * Formats and return validation error response
     *
     * @param $validator
     * @return Response
     **/
    public function validationErrors($validator)
    {
        $errors = $validator->messages();

        foreach ($errors->all() as $error) {
            $error = [
                'title' => 'Input Parameter Error',
                'detail' => $error,
                'status' => self::BAD_REQUEST,
                'code' => ApiError::REQUEST_MISSING_PARAMETER,
            ];

            // Add error
            $this->addError($error);
        }

        return $this->make('BAD_REQUEST');
    }
}
