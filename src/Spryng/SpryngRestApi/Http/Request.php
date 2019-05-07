<?php

namespace Spryng\SpryngRestApi\Http;

class Request
{
    protected $baseUrl;
    protected $httpMethod;
    protected $method;
    protected $headers = array();
    protected $queryStringParameters = array();
    protected $parameters = array();

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

    public function send()
    {
        return new Response();
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