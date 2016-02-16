Overview
=
Small Subscriber/Publisher messaging system.

Package implements One-way Message Exchange Pattern and Request-Reply Message Exchange Pattern.

Observer with Mediator patterns included :)

Requirement
-----------

This library package requires PHP 5.4 or later.

Installation
-

```$ composer require gigi/event-request-response```

Usage
-

Create Messenger instance (singleton)
```php
use gigi\events\classes\Messenger;

$handler = Messenger::getInstance();
```
Subscribe to messages
```php
$handler->subscribe('message.test', function ($message) {
    // do something with message
    // stops further message processing
    $message->setIsHandled(true);

    // optionally return mixed response
    // Will be accessible in reply object (Message::getData())
    return 'Data to return';
});
```
Create message
```php
use gigi\events\classes\Message;

$message = new Message('message.test', 'Mixed data to send');
```

Use one of three methods to publish $message
```php
// one-way notifier
$handler->request($message);
```
```php
// request-response notifier
// Returns array of Messages
$result = $handler->requestReply($message);
```
```php
// request-response notifier
// Returns only first reply (Message object)
// Use if Your don't care of who can return an answer
// for example if you want to get list of all users ('users.get.all')
// or you know for sure that only one subscriber listening

$result = $handler->requestFirstReply($message);
```
For detailed usage see ```examples/singleton.php```.

If singleton makes you cry or your project has own dependency injection container inject ```gigi\classes\MessageHandler``` to new instances of ```gigi\classes\Publisher``` and ```gigi\classes\Subscriber```.
See ```examples/di.php```

Or implement you own classes for interfaces...

Enjoy :)