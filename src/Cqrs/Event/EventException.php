<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cqrs\Event;

/**
 * EventException
 *
 * @author Manfred Weber <manfred.weber@gmail.com>
 */
class EventException extends \Exception
{
    /**
     * Creates a new EventException describing a listener error.
     *
     * @param string $message Exception message
     * @return EventException
     */
    public static function listenerError($message)
    {
        return new self('[Listener Error] ' . $message . "\n");
    }

}
