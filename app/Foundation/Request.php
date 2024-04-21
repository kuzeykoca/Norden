<?php

namespace Norden\Foundation;

class Request
{
    protected object $data;

    public function __construct()
    {
        $this->data = (object)$_REQUEST;
    }

    public function input($key)
    {
        return $this->data->$key ?? null;
    }

    public function getData(): object
    {
        return $this->data;
    }

    public function setData($key, $data): void
    {
        $this->data->$key = $data;
    }
}