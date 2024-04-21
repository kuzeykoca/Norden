<?php

namespace Norden\Foundation\Middleware;

use Norden\Foundation\Request;

abstract class Middleware
{
    abstract public function handle(Request $request, \Closure $next);
}