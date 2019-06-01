<?php

namespace Spryng\SpryngRestApi;

class BaseClient
{
    public $api;

    public function __construct(Spryng $api)
    {
        $this->api = $api;
    }

    /**
     * @return mixed
     */
    public function getApi()
    {
        return $this->api;
    }

    /**
     * @param mixed $api
     */
    public function setApi($api)
    {
        $this->api = $api;
    }
}