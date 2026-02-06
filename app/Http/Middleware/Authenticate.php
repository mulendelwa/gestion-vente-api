<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            // Si c'est une requête API (commence par api/), on ne redirige pas, on laisse le framework renvoyer 401
            if ($request->is('api/*')) {
                return null;
            }
            return route('login');
        }
    }
}
