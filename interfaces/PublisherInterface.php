<?php

/*
 * This file is part of the event-request-response package https://github.com/gigi/event-request-response
 *
 * (c) Alexey Snigirev <http://github.com/gigi>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace gigi\events\interfaces;

/**
 * Basic interface to publish message
 * @package app\interfaces
 */
interface PublisherInterface
{
    /**
     * Asynchronous notifier without reply
     *
     * @param MessageInterface $message
     * @return mixed
     */
    public function request(MessageInterface $message);

    /**
     * Publish event and gathers replies from each subscriber until $message::getIsHandled() == false
     *
     * @param MessageInterface $message
     * @return array of MessageInterface $replyMessages
     */
    public function requestReply(MessageInterface $message);

    /**
     * Only first subscriber's reply will be returned
     *
     * @param MessageInterface $message
     * @return MessageInterface reply message
     */
    public function requestFirstReply(MessageInterface $message);
}