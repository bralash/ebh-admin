<?php

namespace App\Api;

class ValidationException extends \Illuminate\Validation\ValidationException
{
    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return $this->response->validationErrors($this->validator);
    }
}

?>
