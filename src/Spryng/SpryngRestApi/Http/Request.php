<?php

namespace Spryng\SpryngRestApi\Http;

class Request
{
    protected $baseUrl;
    protected $httpMethod;
    protected $method;
    protected $headers = array();
    protected $queryStringParameters = array();

    /**
     * Request constructor.
     * @param $baseUrl
     * @param $httpMethod
     * @param $method
     * @param array $headers
     * @param array $queryStringParameters
     */
    public function __construct($baseUrl, $httpMethod, $method, array $headers = null, array $queryStringParameters = null)
    {
        $this->baseUrl = $baseUrl;
        $this->httpMethod = $httpMethod;
        $this->method = $method;
        $this->headers = $headers;
        $this->queryStringParameters = $queryStringParameters;
    }

    public function withBearerToken($token)
    {
        $this->headers['Authorization'] = sprintf('Bearer %s', $token);

        return $this;
    }
}