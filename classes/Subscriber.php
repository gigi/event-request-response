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

use gigi\events\interfaces\MessageHandlerInterface;
use gigi\events\interfaces\SubscriberInterface;

/**
 * Class Subscriber
 * @package gigi\events\classes
 */
class Subscriber implements SubscriberInterface
{
    protected $handler;

    public function __construct(MessageHandlerInterface $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @return MessageHandlerInterface
     */
    protected function getHandler()
    {
        return $this->handler;
    }

    /**
     * {@inheritdoc}
     */
    public function subscribe($messageName, $handler, $priority = 0, $context = null)
    {
        $this->getHandler()->add($messageName, $handler, $priority, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function unsubscribe($messageName, $handler = null)
    {
        $this->getHandler()->remove($messageName, $handler);
    }
}