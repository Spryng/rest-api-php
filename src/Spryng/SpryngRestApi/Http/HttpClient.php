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
            $this->activeRequest = $req;
        }

        $this->setUrl();
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
    }

    private function executeNoData()
    {

    }

    private function executeWithData()
    {

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
            $headers[] = sprintf('%s: %s', $key, $value);
        }

        // Set converted headers on the curl instance
        if (count($headers) > 0)
        {
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
}