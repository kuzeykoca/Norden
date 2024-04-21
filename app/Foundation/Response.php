<?php

namespace Norden\Foundation;

class Response
{
    protected mixed $statusCode;
    protected array $headers = [];
    protected mixed $body;

    public function __construct($statusCode = 200, $body = '', array $headers = [])
    {
        $this->statusCode = $statusCode;
        $this->body = $body;
        $this->headers = $headers;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getBody(): false|string
    {
        return json_encode($this->body);
    }
}