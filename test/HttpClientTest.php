<?php

namespace Spryng\SpryngRestApi\Test;

use PHPUnit\Framework\TestCase;
use Spryng\SpryngRestApi\Http\HttpClient;

date_default_timezone_set('Europe/Amsterdam');
require_once __DIR__ .'/../vendor/autoload.php';

class HttpClientTest extends TestCase
{
    protected $http;

    public function setUp()
    {
        $this->http = new HttpClient();
    }
}