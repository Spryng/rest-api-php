<?php

namespace Spryng\SpryngRestApi\Http;

use Spryng\SpryngRestApi\ApiResource;
use Spryng\SpryngRestApi\Objects\Balance;
use Spryng\SpryngRestApi\Objects\Message;

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

    protected $rawBody;

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
        $response->setCurlInstance($ch);
        $response->setRawResponse($rawResponse);
        $response->setRawBody($rawResponse);
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
    public function setCurlInstance($curlInstance)
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
    public function setRawResponse($rawResponse)
    {
        $this->rawResponse = $rawResponse;
    }

    /**
     * @return mixed
     */
    public function getRawBody()
    {
        return $this->rawBody;
    }

    /**
     * @param mixed $rawBody
     */
    public function setRawBody($rawBody)
    {
        $headerSize = curl_getinfo($this->curlInstance, CURLINFO_HEADER_SIZE);

        $this->rawBody = substr($rawBody, $headerSize);
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
    public function setResponseCode($responseCode)
    {
        $this->responseCode = $responseCode;
    }

    /**
     * Return a deserialized object from the response
     *
     * @return Message|Balance|array
     */
    public function toObject()
    {
        // Wanted to keep this as simple as possible as there are only 2 objects in the API. Just check if the original
        // url contains 'messages' to know which object to serialize to
        if (false !== strpos(curl_getinfo($this->curlInstance, CURLINFO_EFFECTIVE_URL), 'messages'))
        {
            return ApiResource::deserializeFromRaw($this->getRawBody(), Message::class);
        }

        return ApiResource::deserializeFromRaw($this->getRawBody(), Balance::class);
    }
}