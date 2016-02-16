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

use gigi\events\interfaces\MessageInterface;

/**
 * Message
 */
class Message implements MessageInterface
{
    protected $name;
    protected $data;
    protected $sender;
    protected $isHandled = false;
    protected $replies = [];

    /**
     * Message constructor
     *
     * @param string $name message name
     * @param mixed|null $data
     */
    public function __construct($name, $data = null)
    {
        $this->setName($name);
        $this->setData($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * {@inheritdoc}
     */
    public function setSender($sender)
    {
        $this->sender = $sender;
    }

    /**
     * {@inheritdoc}
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * {@inheritdoc}
     */
    public function setIsHandled($bool)
    {
        $this->isHandled = $bool;
    }

    public function getIsHandled()
    {
        return $this->isHandled;
    }

    /**
     * {@inheritdoc}
     */
    public function addReply(MessageInterface $replyMessage)
    {
        $this->replies[] = $replyMessage;
    }

    /**
     * {@inheritdoc}
     */
    public function getReplies($index = null)
    {
        if ($index !== null) {
            if (isset($this->replies[$index])) {
                return $this->replies[$index];
            }

            return null;
        }

        return $this->replies;
    }

    /**
     * Removes all replies from this message
     */
    public function removeAllReplies()
    {
        $this->replies = [];
    }
}

