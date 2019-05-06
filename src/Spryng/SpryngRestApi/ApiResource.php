<?php

namespace Spryng\SpryngRestApi;

class ApiResource
{
    protected $api;

    /**
     * ApiResource constructor.
     * @param $api
     */
    public function __construct(Spryng $api)
    {
        $this->api = $api;
    }


}