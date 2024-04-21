<?php

namespace Norden\Middlewares;

use Norden\Foundation\Middleware\Middleware;
use Norden\Foundation\Request;

class after extends Middleware
{
    public function handle(Request $request, \Closure $next): void
    {

    }
}