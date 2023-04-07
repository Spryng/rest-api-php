<?php

namespace Spryng\SpryngRestApi\Resources;

use Spryng\SpryngRestApi\ApiResource;
use Spryng\SpryngRestApi\Exceptions\ValidationException;
use Spryng\SpryngRestApi\BaseClient;
use Spryng\SpryngRestApi\Http\HttpClient;
use Spryng\SpryngRestApi\Http\Request;
use Spryng\SpryngRestApi\Http\Response;
use Spryng\SpryngRestApi\Objects\Message;
use Spryng\SpryngRestApi\Utils;

class MessageClient extends BaseClient
{
    /**
     * An array of the existing filters for the list endpoint
     *
     * @var string[]
     */
    private static $listFilters = [
        'originator',
        'recipient_number',
        'reference',
        'created_from',
        'created_until',
        'scheduled_from',
        'scheduled_until',
        'status'
    ];

    public function create(Message $message)
    {
        Utils::assert($message->body);
        Utils::assert($message->originator);
        Utils::assert($message->recipients);

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
            ->addParameter('reference', $message->getReference())
            ->addParameter('scheduled_at', $message->getScheduledAt())
            ->send();
    }

    /**
     * List existing message instances. Use $filters to filter the results
     *
     * @param string[] $filters Filters to limit the results
     *
     * @return Response|null
     * @throws ValidationException
     */
    public function list($filters = [])
    {
        $req = (new Request(
            $this->api->getBaseUrl(),
            HttpClient::METHOD_GET,
            '/messages'
        ))
            ->withBearerToken($this->api->getApiKey());

        // Add the filters as query string parameters
        foreach ($filters as $filter => $value) {
            // check if this filter actually exists
            if (!in_array($filter, self::$listFilters)) {
                throw new ValidationException(sprintf('%s is not a valid filter', $filter));
            }

            $req->addQueryStringParameter(sprintf('filters[%s]', $filter), $value);
        }

        return $req->send();
    }

    /**
     * Cancel a message scheduled in the future.
     *
     * @param string|Message $id The ID of the message to be canceled
     *
     * @return Response
     */
    public function cancel($id)
    {
        if ($id instanceof Message) // also allow message instances
        {
            $id = $id->getId();
        }
        return (new Request(
            $this->api->getBaseUrl(),
            HttpClient::METHOD_POST,
            '/messages/'.$id.'/cancel'
        ))
            ->withBearerToken($this->api->getApiKey())
            ->send();
    }

    /**
     * @deprecated 1.1.0 Use create()
     */
    public function send(Message $message)
    {
        return $this->create($message);
    }

    /**
     * Show the message with $id
     *
     * @param $id The ID of the message to retrieve
     *
     * @return Spryng\SpryngRestApi\Http\Response
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
     * @deprecated 1.10 Use list()
     */
    public function showAll($page = 1, $limit = 15, $filters = array())
    {
        return $this->list($filters);
    }
}
