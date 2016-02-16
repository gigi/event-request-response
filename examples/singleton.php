<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once '../vendor/autoload.php';

use gigi\events\classes\Message;
use gigi\events\classes\Messenger;

/**
 * Singleton example
 */

/**
 * Handler as closure
 */
class Subscriber1
{
    public function init()
    {
        Messenger::getInstance()->subscribe('test', function ($message) {
            echo 'Hello from Subscriber1<br>';

            return 'Answer from 1';
        }, 0, $this);
    }
}

/**
 * Handler as object
 */
class Subscriber2
{
    public function init()
    {
        $priority = 100; //highest priority
        Messenger::getInstance()->subscribe('test', [$this, 'handler'], $priority, $this);
    }

    public function handler($message)
    {
        echo 'Hello from Subscriber2<br>';

        return 'Answer from 2';
    }
}

/**
 * Handler as static method
 */
class Subscriber3
{
    public function init()
    {
        $priority = 20;
        Messenger::getInstance()->subscribe('test', ['Subscriber3StaticClass', 'handler'], $priority, $this);
    }
}

class Subscriber3StaticClass
{
    public static function handler($message)
    {
        echo 'Hello from Subscriber3<br>';

        return 'Answer from 3';
    }
}

(new Subscriber1())->init();
(new Subscriber2())->init();
(new Subscriber3())->init();

$message = new Message('test');
$message->setSender('singletonFile');
$handler = Messenger::getInstance();

// some pretty print if you dont have xdebug
echo '<pre>';
echo '----------------<br>';
echo 'First reply only (with priority order)<br>';
var_dump($handler->requestFirstReply($message));
echo '</pre>';


echo '<pre>';
echo '----------------<br>';
echo 'All replies<br>';
// one more time
$message->setIsHandled(false);
$message->removeAllReplies();
var_dump($handler->requestReply($message));
echo '</pre>';


echo '<pre>';
echo '----------------<br>';
echo 'Asynchronous requests (no response data):<br>';
// one more time
$message->setIsHandled(false);
var_dump($handler->request($message));
echo '</pre>';