<?php

namespace Spryng\SpryngRestApi\Resources;

use Spryng\SpryngRestApi\BaseClient;
use Spryng\SpryngRestApi\Http\HttpClient;
use Spryng\SpryngRestApi\Http\Request;

class BalanceClient extends BaseClient
{
    public function get()
    {
        return (new Request(
            $this->api->getBaseUrl(),
            HttpClient::METHOD_GET,
            '/balance'
        ))
            ->withBearerToken($this->api->getApiKey())
            ->send();
    }
}
