<?php

declare(strict_types=1);

namespace Sassnowski\Venture\Dashboard\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Sassnowski\Venture\Dashboard\Dashboard;

class Authenticate
{
    public function handle(Request $request, Closure $next)
    {
        if (! Dashboard::check($request)) {
            abort(403);
        }

        return  $next($request);
    }
}
