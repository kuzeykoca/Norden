<?php

use Norden\Controllers\TestController;
use Norden\Middlewares\after;
use Norden\Middlewares\before;
use Norden\Foundation\Router\Route;

Route::get('/example',
    [
        'controller' => TestController::class,
        'action' => 'index',
        'before' => [before::class],
        'after' => [after::class]
    ]);