<?php

namespace Spryng\SpryngRestApi\Test;

use PHPUnit\Framework\TestCase;
use Spryng\SpryngRestApi\Spryng;

date_default_timezone_set('Europe/Amsterdam');
require_once __DIR__ . '/../vendor/autoload.php';

class BalanceTest extends TestCase
{
    protected $API_KEY;
    protected $RECIPIENT = [''];
    protected $messageId = '';

    /**
     * @var Spryng
     */
    protected $instance;

    public function setUp()
    {
        parent::setUp();
        $this->API_KEY = file_get_contents(__DIR__ . '/../.apikey');

        $this->instance = new Spryng($this->API_KEY);
    }

    public function testGetBalance()
    {
        $balance = $this->instance->balance->get();

        $this->assertTrue($balance->wasSuccessful());
        $this->assertNotNull($balance->toObject()->getAmount());
        $this->assertTrue(is_float($balance->toObject()->getAmount()));
    }
}
