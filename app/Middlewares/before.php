<?php

namespace Norden\Middlewares;

use Norden\Foundation\Middleware\Middleware;
use Norden\Foundation\Request;

class before extends Middleware
{
    public function handle(Request $request, \Closure $next)
    {
        return $next($request);
    }
}