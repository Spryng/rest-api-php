<?php

namespace Spryng\SpryngRestApi\Http;

use Spryng\SpryngRestApi\Spryng;

class Request
{
    protected $baseUrl;
    protected $httpMethod;
    protected $method;
    protected $headers = array();
    protected $queryStringParameters = array();
    protected $parameters = array();
    protected $client;

    /**
     * Request constructor.
     * @param $baseUrl
     * @param $httpMethod
     * @param $method
     * @param array $headers
     * @param array $queryStringParameters
     */
    public function __construct($baseUrl, $httpMethod, $method, array $headers = array(), array $queryStringParameters = array())
    {
        $this->baseUrl                  = $baseUrl;
        $this->httpMethod               = $httpMethod;
        $this->method                   = $method;
        $this->headers                  = $headers;
        $this->queryStringParameters    = $queryStringParameters;
        $this->client                   = new HttpClient($this);
    }

    public function withBearerToken($token)
    {
        $this->addheader("Authorization", sprintf("Bearer %s", $token));

        return $this;
    }

    public function send()
    {
        return $this->client->send($this);
    }

    public function addParameter($k, $v)
    {
        if (!empty($v))
        {
            $this->parameters[$k] = $v;
        }

        return $this;
    }

    public function addQueryStringParameter($k, $v)
    {
        if (!empty($v))
        {
            $this->queryStringParameters[$k] = $v;
        }

        return $this;
    }

    /**
     * Adds a header to the current header array to be included in the request
     *
     * @param string $name
     * @param string|int $value
     * @return Request
     */
    public function addheader($name, $value)
    {
        $this->headers[$name] = $value;

        return $this;
    }

    /**
     * Get $this->parameters as a JSON formatted string
     *
     * @return false|string
     */
    public function getRequestDataJson()
    {
        return json_encode($this->parameters);
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return mixed
     */
    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    /**
     * @return mixed
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getQueryStringParameters()
    {
        return $this->queryStringParameters;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }
}