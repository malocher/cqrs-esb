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
 * Interface for an EventListener
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
interface EventListenerInterface
{
    /**
     * An EventListener must implement an onEventName-method for each event, it listens to
     * 
     * @example:
     * 
     * A CommandHandler publish an UserAddedEvent and the listener wants to listen to this event,
     * then it must implement the method:
     * 
     * public function onUserAdded(UserAddedEvent $userAddedEvent);
     */
}
