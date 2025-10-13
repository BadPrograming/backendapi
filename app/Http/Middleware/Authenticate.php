<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request): ?string
    {
        // Kalau request API, jangan redirect ke /login
        if ($request->expectsJson()) {
            return null;
        }

        // Agar tidak error "Route [login] not defined"
        return null;
    }
}