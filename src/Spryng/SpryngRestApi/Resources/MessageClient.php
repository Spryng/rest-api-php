<?php

namespace Spryng\SpryngRestApi\Resources;

use Spryng\SpryngRestApi\ApiResource;
use Spryng\SpryngRestApi\BaseClient;
use Spryng\SpryngRestApi\Http\HttpClient;
use Spryng\SpryngRestApi\Http\Request;
use Spryng\SpryngRestApi\Http\Response;
use Spryng\SpryngRestApi\Objects\Message;

class MessageClient extends BaseClient
{
    /**
     * Sends the message to the recipients
     *
     * @param Message $message
     * @return Response
     */
    public function send(Message $message)
    {
        return (new Request(
            $this->api->getBaseUrl(),
            HttpClient::METHOD_POST,
            '/messages'
        ))
            ->withBearerToken($this->api->getApiKey())
            ->addParameter('encoding', $message->getEncoding())
            ->addParameter('body', $message->getBody())
            ->addParameter('route', $message->getRoute())
            ->addParameter('originator', $message->getOriginator())
            ->addParameter('recipients', $message->getRecipients())
            ->send();
    }

    /**
     * Show the message with $id
     *
     * @param $id
     * @return Response
     */
    public function show($id)
    {
        return (new Request(
            $this->api->getBaseUrl(),
            HttpClient::METHOD_GET,
            '/messages/'.$id
        ))
            ->withBearerToken($this->api->getApiKey())
            ->send();
    }

    /**
     * List previously sent messages, possibly with $filters
     *
     * @param array $filters
     * @return Response
     */
    public function list($filters = array())
    {
        $req = (new Request(
            $this->api->getBaseUrl(),
            HttpClient::METHOD_GET,
            '/messages'
        ))
            ->withBearerToken($this->api->getApiKey());

        // Add the filters as query string parameters
        foreach ($filters as $filter => $value)
        {
            $req->addQueryStringParameter($filter, $value);
        }

        return $req->send();
    }
}