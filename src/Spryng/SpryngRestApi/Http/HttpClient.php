<?php

namespace Spryng\SpryngRestApi\Http;

class HttpClient
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';

    protected $ch;

    /**
     * @var Request
     */
    protected $activeRequest;

    protected $baseUrl;

    protected $response;
    protected $responseCode;

    public function __construct($baseUrl = null)
    {
        $this->ch = curl_init();

        if ($baseUrl !== null)
        {
            $this->baseUrl = $baseUrl;
        }
    }

    public function send(Request $request)
    {

    }
}