<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Illuminate\Session\TokenMismatchException;

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
        //
    ];

    /**
     * Always verify the CSRF token if present in the request.
     */
    public function handle($request, Closure $next)
    {
        if ($this->getTokenFromRequest($request) && !$this->tokensMatch($request)) {
            throw new TokenMismatchException('CSRF token mismatch.');
        }

        return parent::handle($request, $next);
    }

    /**
     * @inheritDoc
     */
    protected function getTokenFromRequest($request)
    {
        if ($request->route('_token')) {
            return $request->route('_token');
        }

        return parent::getTokenFromRequest($request);
    }
}
