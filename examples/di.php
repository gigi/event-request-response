<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once '../vendor/autoload.php';

use gigi\events\classes\Message;
use gigi\events\classes\MessageHandler;
use gigi\events\classes\Subscriber;
use gigi\events\classes\Publisher;

/**
 * Example for DIC integration
 */
$handler = new MessageHandler();
$publisher = new Publisher($handler);

$subscriber1 = new Subscriber($handler);
$subscriber2 = new Subscriber($handler);

$subscriber1->subscribe('test.message', function($message) {
    echo 'hello from subscriber 1<br>';

    return 'Response from subscriber 1';
}, 0);
class InnerClassExample {

    public function sub($subscriber)
    {
        $subscriber->subscribe('test.message', function($message) {
            echo 'hello from subscriber 2<br>';

            return 'Response from subscriber 2';
        }, 10, $this);
    }

}

(new InnerClassExample())->sub($subscriber2);


$message = new Message('test.message', 'data to send');
$replies = $publisher->requestReply($message);

var_dump($replies);