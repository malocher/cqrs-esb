<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Iteration\Iteration1;

use Cqrs\Adapter\AdapterTrait;

/**
 * Class Iteration1Handler
 *
 * Note the use of the AdapterTrait which loosely couples this file with the cqrs package
 *
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 * @author Manfred Weber <crafics@php.net>
 * @package Iteration\Iteration1
 */
class Iteration1Handler
{
    use AdapterTrait;

    /**
     * „Command handler perform the following tasks:
     *
     * 1. It receives a command instance from the messaging infrastructure.
     * 2. It validates that the command is a valid command.
     * 3. It locates the aggregate instance that is the target of the command.
     *    This may involve creating a new aggregate instance or locating an existing instance.
     * 4. It invokes the appropriate method on the aggregate instance, passing in any parameters from the command.
     * 5. It persists the new state of the aggregate to storage.“
     *
     * „Exploring CQRS and Event Sourcing.“
     * iBooks. https://itunes.apple.com/WebObjects/MZStore.woa/wa/viewBook?id=85A96D9C4AEBE2F2D588B4683CCF608E
     *
     * @param Iteration1Command $command
     */
    public function editCommand(Iteration1Command $command)
    {
        $command->edit();
        print sprintf("%s says: %s ... Command\n", __METHOD__, $command->getPayload());
        $event = new Iteration1Event('Hello');
        $event->edit();
        $this->getBus()->publishEvent($event);
    }

    /**
     * Events are published to multiple recipients, typically aggregate instances or process managers.
     * The Event handler performs the following tasks:
     *
     * 1. It receives an Event instance from the messaging infrastructure.
     * 2. It locates the aggregate or process manager instance that is the target of the event.
     *    This may involve creating a new ag
     *
     * „Exploring CQRS and Event Sourcing.“
     * iBooks. https://itunes.apple.com/WebObjects/MZStore.woa/wa/viewBook?id=85A96D9C4AEBE2F2D588B4683CCF608E
     *
     * @param Iteration1Event $event
     */
    public function editEvent(Iteration1Event $event)
    {
        print sprintf("%s says: %s ... Event\n", __METHOD__, $event->getPayload());
    }
}
