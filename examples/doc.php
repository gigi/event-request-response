<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once '../vendor/autoload.php';

use gigi\events\classes\Messenger;

$handler = Messenger::getInstance();

$handler->subscribe('message.test', function ($message) {
    // do something with message
    // stops further message processing
    $message->setIsHandled(true);
    $receivedData = $message->getData();

    // optionally return mixed response
    // Will be accessible in reply object (Message::getData())
    return 'Data to return';
});


use gigi\events\classes\Message;

$message = new Message('message.test', 'Mixed data to send');

// async notifier
//$handler->request($message);

// sync notifier
// Returns array of Messages
//$result = $handler->requestReply($message);

// sync notifier
// Returns only first reply (Message object)
$result = $handler->requestFirstReply($message);

echo '<pre>';
var_dump($result);
echo '</pre>';