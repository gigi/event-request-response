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
 * Interface SubscriberInterface
 * @package app\interfaces
 */
interface SubscriberInterface
{
    /**
     * @param string $messageName
     * @param mixed $handler [class, method], [object, method] or closure function(MessageInterface $message)
     * @see call_user_func
     * @param int $priority higher priority will be handled first
     * @param mixed $context current class or object to identify handler
     *
     * @return mixed
     */
    public function subscribe($messageName, $handler, $priority = 0, $context = null);

    /**
     * @param string $messageName
     * @param mixed $handler [class, method], [object, method] or closure function(MessageInterface $message)
     * if null all events will be removed
     *
     * @return mixed
     */
    public function unsubscribe($messageName, $handler = null);
}