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
 * Basic interface for messaging
 * @package app\interfaces
 */
interface MessageInterface
{
    /**
     * Gets message name
     *
     * @return string
     */
    public function getName();

    /**
     * Sets message name
     *
     * @param $name
     * @return mixed
     */
    public function setName($name);

    /**
     * Returns data (mixed data)
     *
     * @return mixed
     */
    public function getData();

    /**
     * Sets message
     *
     * @param mixed $data to send
     * @return mixed
     */
    public function setData($data);

    /**
     * Sender object
     *
     * @return object
     */
    public function getSender();

    /**
     * Sets sender (object, class or closure)
     *
     * @param $sender
     * @return mixed
     */
    public function setSender($sender);

    /**
     * Flag if message already handled
     *
     * @return bool
     */
    public function getIsHandled();

    /**
     * Flag if event already handled
     *
     * @param $bool
     * @return bool
     */
    public function setIsHandled($bool);

    /**
     * Returns all replies for the message
     *
     * @param int $index key number of reply. If null returns all replies
     * @return array
     */
    public function getReplies($index = null);

    /**
     * Adds reply to message
     *
     * @param MessageInterface $reply
     * @return mixed
     */
    public function addReply(MessageInterface $reply);
}