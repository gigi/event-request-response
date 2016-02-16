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
use gigi\events\interfaces\PublisherInterface;
use gigi\events\interfaces\MessageInterface;

/**
 * Class Publisher
 * @package gigi\events\classes
 */
class Publisher implements PublisherInterface
{
    /** @var MessageHandlerInterface */
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
    public function request(MessageInterface $message)
    {
        $this->getHandler()->handle($message);
    }

    /**
     * {@inheritdoc}
     */
    public function requestReply(MessageInterface $message)
    {
        $this->getHandler()->handle($message, MessageHandlerInterface::MODE_REPLY);

        return $message->getReplies();
    }

    /**
     * {@inheritdoc}
     */
    public function requestFirstReply(MessageInterface $message)
    {
        $this->getHandler()->handle($message, MessageHandlerInterface::MODE_REPLY_FIRST);

        return $message->getReplies(0);
    }
}