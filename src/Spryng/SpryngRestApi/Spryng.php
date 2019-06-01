<?php

namespace Spryng\SpryngRestApi;

use Spryng\SpryngRestApi\Http\HttpClient;
use Spryng\SpryngRestApi\Resources\BalanceClient;
use Spryng\SpryngRestApi\Resources\MessageClient;

class Spryng
{
    const VERSION = '1.0.0';

    protected $baseUrl = 'https://rest.spryngsms.com/v1';

    /**
     * @var MessageClient
     */
    public $message;

    /**
     * @var BalanceClient
     */
    public $balance;

    public static $http;

    protected $apiKey;

    public function __construct($apiKey = null)
    {
        if ($apiKey !== null)
        {
            $this->setApiKey($apiKey);
        }

        self::$http = new HttpClient();

        $this->message = new MessageClient($this);
        $this->balance = new BalanceClient($this);
    }

    /**
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param mixed $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * Get the current version of the library
     *
     * @return string
     */
    public function getVersion()
    {
        return self::VERSION;
    }
}
