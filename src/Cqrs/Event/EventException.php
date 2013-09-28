<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cqrs\Event;

/**
 * Class EventException
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Cqrs\Event
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
