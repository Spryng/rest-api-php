<?php

namespace Spryng\SpryngRestApi\Test;

use PHPUnit\Framework\TestCase;
use Spryng\SpryngRestApi\Exceptions\ValidationException;
use Spryng\SpryngRestApi\Objects\Message;
use Spryng\SpryngRestApi\Spryng;

date_default_timezone_set('Europe/Amsterdam');
require_once __DIR__ . '/../vendor/autoload.php';

class MessageTest extends TestCase
{
    protected $API_KEY;
    protected $RECIPIENT = [''];
    protected $messageId = '90797ce7-a20d-434a-9c00-553e31d9ce03';

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
        $message->setEncoding('plain');

        $response = $this->instance->message->create($message);

        $this->assertTrue($response->wasSuccessful());
    }

    public function testMissingRequiredParametersThrowsException()
    {
        $message = new Message();
        $message->setBody('test!');
        $message->setRecipients($this->RECIPIENT);
        // Originator is missing

        $this->expectException(ValidationException::class);
        $this->instance->message->create($message);
    }

    public function testGetMessage()
    {
        $response = $this->instance->message->show($this->messageId);

        $this->assertTrue($response->wasSuccessful());

        $obj = $response->toObject();
        $this->assertNotNull($obj->getId());
        $this->assertNotNull($obj->getBody());
        $this->assertNotNull($obj->getReference());
        $this->assertNotNull($obj->getCreatedAt());
    }

    public function testScheduleAndCancelMessage()
    {
        $message = new Message();
        $message->setBody('Scheduled');
        $message->setOriginator('Spryng');
        $message->setRecipients($this->RECIPIENT);
        $message->setScheduledAt('2022-01-01T15:00:00+00:00');

        $response = $this->instance->message->create($message);
        $this->assertTrue($response->wasSuccessful());
        $message = $response->toObject();

        $response = $this->instance->message->cancel($message->getId());
        $this->assertTrue($response->wasSuccessful());
    }

    public function testShowAll()
    {
        $response = $this->instance->message->showAll(1, 20);

        $this->assertTrue($response->wasSuccessful());
        $obj = $response->toObject();
        // Check if the response is correctly parsed to objects for all the messages
        if (count($obj->getData()) > 0)
        {
            foreach ($obj->getData() as $message)
            {
                $this->assertNotNull($message->getId());
            }
        }
    }
}
