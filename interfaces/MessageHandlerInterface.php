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
 * Interface MessageHandlerInterface
 * @package gigi\events\interfaces
 */
interface MessageHandlerInterface
{
    const MODE_ASYNC = 0;
    const MODE_REPLY = 1;
    const MODE_REPLY_FIRST = 2;

    /**
     * Appends message to events array
     *
     * @param string $messageName
     * @param callback $handler
     * @param integer $priority for message processing. Higher priority will be handled first
     * @param mixed $context current object or class caller
     */
    public function add($messageName, $handler, $priority, $context = null);

    /**
     * Removes handler from events array
     *
     * @param $messageName
     * @param null $handler
     * @return bool
     */
    public function remove($messageName, $handler = null);

    /**
     * Message handler iterator
     *
     * @param MessageInterface $message
     * @param int $mode
     * @return MessageInterface $message|null
     */
    public function handle(MessageInterface &$message, $mode = self::MODE_ASYNC);
}