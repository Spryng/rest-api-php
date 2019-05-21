<?php

namespace Spryng\SpryngRestApi\Test;

use PHPUnit\Framework\TestCase;
use Spryng\SpryngRestApi\Objects\Message;
use Spryng\SpryngRestApi\Resources\MessageClient;
use Spryng\SpryngRestApi\Spryng;

date_default_timezone_set('Europe/Amsterdam');
require_once __DIR__ . '/../vendor/autoload.php';

class MessageTest extends TestCase
{
    protected $API_KEY;
    protected $RECIPIENT = [];

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

    public function testSendMessage()
    {
        $message = new Message();
        $message->setBody('test!');
        $message->setRecipients($this->RECIPIENT);
        $message->setOriginator('Spryng');

        $response = $this->instance->message->send($message);

        $this->assertTrue($response->wasSuccessful());
    }
}