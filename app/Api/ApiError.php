<?php

namespace App\Api;

class ApiError
{
    // API status codes
    const API_KEY_NULL = 1000;
    const API_KEY_MISMATCH = 1001;
    const API_ACCESS_DENIED = 1002;

    // Request payload
    const REQUEST_MISSING_PARAMETER = 1003;
}
