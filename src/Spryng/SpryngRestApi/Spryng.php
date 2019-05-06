<?php

namespace Spryng\SpryngRestApi;

use Spryng\SpryngRestApi\Resources\Balance;
use Spryng\SpryngRestApi\Resources\Message;

class Spryng
{
    const VERSION = '0.1.0';

    protected $baseUrl = 'https://rest.spryngsms.com/v1';

    /**
     * @var Message
     */
    public $message;

    /**
     * @var Balance
     */
    public $balance;

    public $http;

    protected $apiKey;

    public function __construct($apiKey = null)
    {
        if ($apiKey !== null)
        {
            $this->setApiKey($apiKey);
        }

        $this->message = new Message();
        $this->balance = new Balance();
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
}