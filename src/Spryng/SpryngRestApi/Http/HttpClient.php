<?php

namespace Spryng\SpryngRestApi\Http;

class HttpClient implements HttpClientInterface
{
    const METHOD_GET    = 'GET';
    const METHOD_POST   = 'POST';
    const METHOD_PATCH  = 'PATCH';
    const METHOD_DELETE = 'DELETE';

    /**
     * @var false|resource
     */
    protected $ch;

    /**
     * @var Request
     */
    protected $activeRequest;

    /**
     * @var Response|null
     */
    protected $lastResponse;

    public function __construct(Request $req = null)
    {
        $this->ch = curl_init();

        if ($req !== null)
        {
            $this->setActiveRequest($req);
        }
    }

    public function send(Request $req = null)
    {
        if ($req === null) {
            if ($this->activeRequest === null) {
                throw new \RuntimeException('There is no active request and none is provided.');
            }
        } else {
            $this->setActiveRequest($req);
        }

        $this->setUrl();

        // Don't print the result
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        switch ($this->activeRequest->getHttpMethod())
        {
            case self::METHOD_GET:
            case self::METHOD_DELETE:
                $this->lastResponse = $this->executeNoData();
                break;
            case self::METHOD_POST:
            case self::METHOD_PATCH:
                $this->lastResponse = $this->executeWithData();
                break;
            default:
                throw new \RuntimeException(
                    sprintf('HTTP method %s not supported.', $this->activeRequest->getHttpMethod())
                );
                break;
        }

        return $this->getLastResponse();
    }

    private function executeNoData()
    {
        // Set the request method to the request
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $this->activeRequest->getHttpMethod());
        $this->applyHeaders();

        $rawResponse = curl_exec($this->ch);
        return Response::constructFromCurlResponse($this->ch, $rawResponse);
    }

    private function executeWithData()
    {
        // Set the request method to the request
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $this->activeRequest->getHttpMethod());
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $this->activeRequest->getRequestDataJson());

        // Since we're sending JSON data, set the content type and length headers
        $this->activeRequest->addheader('Content-Type', 'application/json');
        $this->activeRequest->addheader('Content-Length', strlen($this->activeRequest->getRequestDataJson()));
        $this->applyHeaders();

        $rawResponse = curl_exec($this->ch);
        return Response::constructFromCurlResponse($this->ch, $rawResponse);
    }

    /**
     * Sets the current request to be activated to $req
     *
     * @param Request $req
     * @return HttpClientInterface
     */
    public function setActiveRequest(Request $req)
    {
        $this->activeRequest = $req;

        return $this;
    }

    /**
     * Returns the lastResponse of the last request that was send.
     *
     * @return Response
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    /**
     * Formats the active headers in the request and sets them on the curl instance.
     * Returns $this for chaining.
     *
     * @return $this
     */
    private function applyHeaders()
    {
        // Convert associative array of headers with key and value to single string headers
        $headers = array();
        foreach ($this->activeRequest->getHeaders() as $key => $value) {
            // Apply the user agent header using the CURLOPT_USERAGENT option
            if (strtolower($key) === 'user-agent')
            {
                curl_setopt($this->ch, CURLOPT_USERAGENT, $value);
                continue;
            }
            $headers[] = sprintf('%s: %s', $key, $value);
        }

        // Set converted headers on the curl instance
        if (count($headers) > 0)
        {
            curl_setopt($this->ch, CURLOPT_HEADER, true);
            curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);
        }

        // Return for chaining
        return $this;
    }

    /**
     * Formats the target URL including query string and sets it as the curl target.
     * Returns $this for chaining.
     *
     * @return $this
     */
    private function setUrl()
    {
        // The URL is the base url + the method (uri)
        $url = sprintf('%s%s', $this->activeRequest->getBaseUrl(), $this->activeRequest->getMethod());

        // If any query string parameters are set, format them and add to the URL.
        if (count($this->activeRequest->getQueryStringParameters()) > 0)
        {
            $url .= sprintf('?%s', http_build_query($this->activeRequest->getQueryStringParameters()));
        }

        // Set the full URL as the target for curl
        curl_setopt($this->ch, CURLOPT_URL, $url);

        // Return for chaining
        return $this;
    }

    /**
     * @return false|resource
     */
    public function getActiveCurlInstance()
    {
        return $this->ch;
    }

    /**
     * @return Request
     */
    public function getActiveRequest()
    {
        return $this->activeRequest;
    }
}