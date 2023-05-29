<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate;

class AuthenticateWithToken extends Authenticate
{
    protected function authenticate($request, array $guards)
    {
        if ($this->auth->guard('api')->check()) {
            return $this->auth->shouldUse('api');
        }

        throw new AuthenticationException('Unauthenticated.');
    }
}
