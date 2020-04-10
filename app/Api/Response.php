<?php

declare(strict_types=1);

namespace App\Api;

abstract class Response {
    // Standard HTTP status codes
    const OK = 200;
    const CREATED = 201;
    const NOT_MODIFIED = 304;
    const BAD_REQUEST = 400;
    const UNAUTHORIZED = 401;
    const FORBIDDEN = 403;
    const NOT_FOUND = 404;
    const UNSUPPORTED_MEDIA_TYPE = 415;
    const INTERNAL_SERVER_ERROR = 500;

    protected $response;
    protected $headers = array();

    abstract protected function formatResponse();
    abstract protected function buildResponse(bool $data, string $status);
    abstract protected function make(string $status);
    abstract protected function forbidden($code, $message);
    abstract protected function notFound($code, $message);

    /**
     * Adds a header to response
     *
     * @param \string $header
     * @param \string $value
     * @return void
     */
    public function setHeader($header, $value)
    {
        $this->headers[$header] = $value;
    }

    /**
     * Returns OK STATUS
     *
     * @return response
     **/
    public function ok()
    {
        return $this->make('OK');
    }

    /**
     * Returns BAD_REQUEST STATUS response
     *
     * @return response
     **/
    public function bad()
    {
        return $this->make('BAD_REQUEST');
    }
}
