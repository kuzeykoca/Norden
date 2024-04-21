<?php

use Norden\Foundation\Kernel;
use Norden\Foundation\Logger;

set_error_handler(function ($severity, $message, $file, $line) {
    http_response_code(500);
    echo json_encode([
        'error' => [
            'message' => $message,
            'file' => $file,
            'line' => $line
        ]
    ]);
    exit;
});

set_exception_handler(function ($exception) {
    http_response_code(500);
    echo json_encode([
        'error' => [
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTrace()
        ]
    ]);
    exit;
});

try {
    Kernel::handleRequest();
} catch (\Exception $e) {
    http_response_code(500);
    $error = [
        'error' => [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTrace()
        ]
    ];

    echo json_encode($error);
    Logger::log(print_r($error, true));
    exit;
}