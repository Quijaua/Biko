<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\PreventRequestForgery as Middleware;

/**
 * Proteção CSRF do Laravel 13 (substitui VerifyCsrfToken).
 *
 * Primeiro confere o header Sec-Fetch-Site (requisições da mesma origem
 * passam direto); se não der para confirmar a origem, valida o token
 * _token / X-CSRF-TOKEN como antes.
 */
class PreventRequestForgery extends Middleware
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
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
}
