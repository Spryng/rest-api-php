<?php

namespace Spryng\SpryngRestApi\Http;

class Response
{
    /**
     * The cURL instance used for the request
     *
     * @var resource
     */
    protected $curlInstance;

    /**
     * The raw string response to the request
     *
     * @var string
     */
    protected $rawResponse;

    /**
     * The HTTP response code that was received
     *
     * @var int
     */
    protected $responseCode;

    /**
     * Constructs a Response instance straight from the raw response of a curl instance, and the instance itself.
     *
     * @param $ch
     * @param $rawResponse
     * @return Response
     */
    public static function constructFromCurlResponse($ch, $rawResponse)
    {
        $response = new self();
        $response->setRawResponse($rawResponse);
        $response->setCurlInstance($ch);
        $response->setResponseCode(curl_getinfo($ch, CURLINFO_RESPONSE_CODE));

        return $response;
    }

    /**
     * Indicates if this was a successful request by evaluating the response code.
     *
     * @return bool
     */
    public function wasSuccessful()
    {
        return ($this->getResponseCode() >= 200 && $this->getResponseCode() < 300);
    }

    /**
     * Indicates if a failed request was a fault of the server
     *
     * @return bool
     */
    public function serverError()
    {
        return ($this->getResponseCode() >= 500 && $this->getResponseCode() <= 599);
    }

    /**
     * @param mixed $curlInstance
     */
    public function setCurlInstance($curlInstance): void
    {
        $this->curlInstance = $curlInstance;
    }

    /**
     * @return mixed
     */
    public function getRawResponse()
    {
        return $this->rawResponse;
    }

    /**
     * @param mixed $rawResponse
     */
    public function setRawResponse($rawResponse): void
    {
        $this->rawResponse = $rawResponse;
    }

    /**
     * @return mixed
     */
    public function getResponseCode()
    {
        return $this->responseCode;
    }

    /**
     * @param mixed $responseCode
     */
    public function setResponseCode($responseCode): void
    {
        $this->responseCode = $responseCode;
    }
}