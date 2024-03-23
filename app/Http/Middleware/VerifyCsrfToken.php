<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/sslcommerz*',
        '/config_content',
        '/paytm*',
        '/payhere*',
        '/stripe*',
        '/iyzico*',
        '/payfast*',
        'api/v2/payfast*',
        '/bkash*',
        'api/v2/bkash*',
        '/aamarpay*',
        '/mock_payments',
        '/apple-callback',
        '/lnmo*',
        '/rozer*',
        '/phonepe*',
        '/import-data',
    ];
}
