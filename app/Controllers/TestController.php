<?php

namespace Norden\Controllers;

use Norden\Foundation\Request;
use Norden\Foundation\Response;

class TestController
{
    public function index(Request $request): Response
    {
        return new Response(200, "Hello World!");
    }
}