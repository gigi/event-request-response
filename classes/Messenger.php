<?php

/*
 * This file is part of the event-request-response package https://github.com/gigi/event-request-response
 *
 * (c) Alexey Snigirev <http://github.com/gigi>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace gigi\events\classes;

use gigi\events\interfaces\PublisherInterface;
use gigi\events\interfaces\SubscriberInterface;
use gigi\events\interfaces\MessageInterface;

/**
 * Singleton wrapper for single instance and hard dependencies
 * @package gigi\events\classes
 */
class Messenger implements SubscriberInterface, PublisherInterface
{
    protected static $instance;
    protected $publisher;
    protected $subscriber;

    /**
     * closing constructor
     */
    private function __construct()
    {
        $messageHandler = new MessageHandler();
        $this->publisher = new Publisher($messageHandler);
        $this->subscriber = new Subscriber($messageHandler);
    }

    /**
     * closing clone
     */
    private function __clone()
    {
    }

    /**
     * Singleton instance
     *
     * @return static
     */
    public static function getInstance()
    {
        if (empty(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    /**
     * @return Publisher
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * @return Subscriber
     */
    public function getSubscriber()
    {
        return $this->subscriber;
    }

    /**
     * {@inheritdoc}
     */
    public function request(MessageInterface $message)
    {
        $this->getPublisher()->request($message);
    }

    /**
     * {@inheritdoc}
     */
    public function requestReply(MessageInterface $message)
    {
        return$this->getPublisher()->requestReply($message);
    }

    /**
     * {@inheritdoc}
     */
    public function requestFirstReply(MessageInterface $message)
    {
        return $this->getPublisher()->requestFirstReply($message);
    }

    /**
     * {@inheritdoc}
     */
    public function subscribe($messageName, $handler, $priority = 0, $context = null)
    {
        $this->getSubscriber()->subscribe($messageName, $handler, $priority, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function unsubscribe($messageName, $handler = null)
    {
        $this->getSubscriber()->unsubscribe($messageName, $handler);
    }
}