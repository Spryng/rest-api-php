<?php

namespace Spryng\SpryngRestApi\Resources;

use Spryng\SpryngRestApi\ApiResource;
use Spryng\SpryngRestApi\Http\HttpClient;
use Spryng\SpryngRestApi\Http\Request;
use Spryng\SpryngRestApi\Http\Response;

class Message extends ApiResource
{
    protected $encoding;
    protected $body;
    protected $route;
    protected $originator;
    protected $recipients;

    /**
     * @return mixed
     */
    public function getEncoding()
    {
        return $this->encoding;
    }

    /**
     * Sends the message to the recipients
     *
     * @return Response
     */
    public function send()
    {
        return (new Request(
            $this->api->getBaseUrl(),
            HttpClient::METHOD_POST,
            '/messages'
        ))
            ->withBearerToken($this->api->getApiKey())
            ->addParameter('encoding', $this->getEncoding())
            ->addParameter('body', $this->getBody())
            ->addParameter('route', $this->getRoute())
            ->addParameter('originator', $this->getOriginator())
            ->addParameter('recipients', $this->getRecipients())
            ->send();
    }

    /**
     * @param mixed $encoding
     */
    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     * @return Message
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param mixed $route
     */
    public function setRoute($route)
    {
        $this->route = $route;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOriginator()
    {
        return $this->originator;
    }

    /**
     * @param mixed $originator
     */
    public function setOriginator($originator)
    {
        $this->originator = $originator;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRecipients()
    {
        return $this->recipients;
    }

    /**
     * @param mixed $recipients
     */
    public function setRecipients($recipients)
    {
        $this->recipients = $recipients;
        return $this;
    }


}