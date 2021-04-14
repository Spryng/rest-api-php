## Spryng SMS REST Library for PHP

This repository contains the source code for the Spryng SMS REST API library for PHP. This library will make it very easy to integrate the SMS gateway into your application. It offers all the functionality that the API has to offer.

### Installation

Installation is easily done using composer:

```bash
composer require spryng/rest-api-php
```

When the installation is complete, you can initialize the library with your API key:

```php
require_once "vendor/autoload.php";

use Spryng\SpryngRestApi\Spryng;

$spryng = new Spryng($apiKey);

```

### Sending messages

To send a message, supply the `send` method with the information about the message you'd like to send:

```php
use Spryng\SpryngRestApi\Objects\Message;
use Spryng\SpryngRestApi\Spryng;

$spryng = new Spryng($apiKey);

$message = new Message();
$message->setBody('My message');
$message->setRecipients(['31612344567', '31698765432']);
$message->setOriginator('My Company');

$response = $spryng->message->send($message);

if ($response->wasSuccessful())
{
	$message = $response->toObject();
	echo "Message with ID " . $message->getId() . " was sent successfully!\n";
}
else if ($response->serverError())
{
	echo "Message could not be sent because of a server error...\n";
}
else
{
	echo "Message could not be sent. Response code: " . $response->getResponseCode() ."\n";
}
```

### Getting info about a message

Single messages can be queried by their ID:

```php
use Spryng\SpryngRestApi\Objects\Message;
use Spryng\SpryngRestApi\Spryng;

$spryng = new Spryng($apiKey);

$response = $spryng->message->getMessage("9dbc5ffb-7524-4fae-9514-51decd94a44f");

if ($resposne->wasSuccessful())
{
	echo "The body of the message is: " . $response->toObject()->getBody() . "\n";
}
```

### Listing messages

You can list the messages you have send in a paginated manner. You can also apply filters to get a sub-set of the messages you have sent:

```php
use Spryng\SpryngRestApi\Objects\Message;
use Spryng\SpryngRestApi\Spryng;

$spryng = new Spryng($apiKey);

$response = $spryng->message->showAll(
	1, // page
	20, // limit: items per page
	[ // An array of filters
		'recipient_number' => '31612345667'
	]
);

if ($response->wasSuccessful())
{
	// Will return an instance of MessageCollection
	$messages = $response->toObject();
	echo "Found " . $messages->getTotal() . " results:\n";
	
	foreach ($messages->getData() as $message)
	{
		echo sprintf("ID: %s ('%s') sent on: %s\n", 
			$message->getId(), 
			$message->getBody(), 
			$message->getCreatedAt()
		);
	}
}

```

### Getting your balance

You can also check the remaining credit balance on your account:

```php
use Spryng\SpryngRestApi\Objects\Message;
use Spryng\SpryngRestApi\Spryng;

$spryng = new Spryng($apiKey);

$balance = $spryng->balance->get()->toObject();
echo "You have " . $balance->getAmount() . " credits remaining\n";
```
