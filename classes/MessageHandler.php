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
use gigi\events\interfaces\MessageInterface;

/**
 * Class MessageHandler manages events and messages
 * @package gigi\events\classes
 */
class MessageHandler implements MessageHandlerInterface
{
    /** Reply message name */
    const REPLY_MESSAGE_NAME = "replyMessage";

    protected $events = [];

    /**
     * {@inheritdoc}
     */
    public function add($messageName, $handler, $priority, $context = null)
    {
        $this->events[$messageName][] = [
            'context' => $context,
            'handler' => $handler,
            'priority' => $priority,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function remove($messageName, $handler = null)
    {
        if (!isset($this->events[$messageName])) {
            return false;
        }
        if ($handler == null) {
            unset($this->events[$messageName]);
            return true;
        }
        foreach ($this->events[$messageName] as $key => $event) {
            if ($handler == $event['handler']) {
                unset($this->events[$messageName][$key]);
            }
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(MessageInterface &$message, $mode = self::MODE_ASYNC)
    {
        $handlers = $this->getHandlers($message->getName());
        $totalHandlers = count($handlers);
        if ($totalHandlers == 0) {
            $message->setIsHandled(true);
            return;
        }
        $i = 0;
        while ($message->getIsHandled() === false || $totalHandlers < $i) {
            $handler = $handlers[$i]['handler'];
            $context = $handlers[$i]['context'];
            $this->processMessage($message, $handler, $context, $mode);
            $i++;
            if ($totalHandlers === $i) {
                $message->setIsHandled(true);
            }
        }
    }

    /**
     * One message processing
     *
     * @param MessageInterface $message
     * @param callback $function
     * @see call_user_func
     * @param $context
     * @param int $mode
     */
    protected function processMessage(&$message, $function, $context, $mode)
    {
        if (!is_callable($function)) {
            throw new \InvalidArgumentException('Handler ' . var_export($function, true) . ' not found');
        }
        $reply = call_user_func($function, $message);
        if ($mode !== MessageHandlerInterface::MODE_ASYNC) {
            $replyMessage = $this->createReply($reply, $context);
            $message->addReply($replyMessage);
            if ($mode == MessageHandlerInterface::MODE_REPLY_FIRST) {
                $message->setIsHandled(true);
            }
        }
    }

    /**
     * Creating reply message
     *
     * @param mixed $data to send
     * @param mixed $sender class, object or logical param ($context param)
     * @see \gigi\events\interfaces\SubscriberInterface::subscribe()
     *
     * @return Message
     */
    protected function createReply($data, $sender)
    {
        $replyMessage = new Message(static::REPLY_MESSAGE_NAME, $data);
        $replyMessage->setSender($sender);

        return $replyMessage;
    }

    /**
     * Returns all handlers by name
     *
     * @param $messageName
     * @return array
     */
    protected function getHandlers($messageName)
    {
        if (!empty($this->events[$messageName])) {
            return $this->sortByPriority($this->events[$messageName]);
        }

        return [];
    }

    /**
     * Sorts handlers by priority (stable sort)
     *
     * @param array $handlers
     * @return array
     */
    protected function sortByPriority($handlers = [])
    {
        static::usort($handlers, function ($a, $b) {
            return $b['priority'] - $a['priority'];
        });

        return $handlers;
    }

    /**
     * Stable usort function
     * Saves original array order
     *
     * @link https://github.com/vanderlee/PHP-stable-sort-functions/blob/master/classes/StableSort.php
     *
     * @param array $array
     * @param $value_compare_func
     * @return bool
     */
    public static function usort(array &$array, $value_compare_func)
    {
        $index = 0;
        foreach ($array as &$item) {
            $item = array($index++, $item);
        }
        $result = usort($array, function ($a, $b) use ($value_compare_func) {
            $result = call_user_func($value_compare_func, $a[1], $b[1]);
            return $result == 0 ? $a[0] - $b[0] : $result;
        });
        foreach ($array as &$item) {
            $item = $item[1];
        }
        return $result;
    }

}