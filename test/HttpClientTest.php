<?php

namespace Spryng\SpryngRestApi\Test;

use PHPUnit\Framework\TestCase;
use Spryng\SpryngRestApi\Http\HttpClient;
use Spryng\SpryngRestApi\Http\Request;

date_default_timezone_set('Europe/Amsterdam');
require_once __DIR__ .'/../vendor/autoload.php';

class HttpClientTest extends TestCase
{
    public function testSetUrl()
    {
        // Test without query string parameters
        $req = new Request(
            'https://example.com',
            HttpClient::METHOD_GET,
            '/create'
        );
        $http = new HttpClient($req);
        $http->send();
        $info = curl_getinfo($http->getActiveCurlInstance());

        $this->assertEquals('https://example.com/create', $info['url']);

        // Test with query string parameters
        $req = (new Request(
            'https://example.com',
            HttpClient::METHOD_GET,
            '/create'
        ))
            ->addQueryStringParameter('key1', 'value1')
            ->addQueryStringParameter('key2', 'value2');
        $http = new HttpClient($req);
        $http->send();
        $info = curl_getinfo($http->getActiveCurlInstance());

        $this->assertEquals('https://example.com/create?key1=value1&key2=value2', $info['url']);
    }
}