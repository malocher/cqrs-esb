<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Iteration\Iteration1;

use Malocher\Cqrs\Event\EventInterface;
use Malocher\Cqrs\Message\Message;

/**
 * Class Iteration1Event
 *
 * „Events can play two different roles in a CQRS implementation.
 * Event sourcing. As described previously, event sourcing is an approach to persisting
 * the state of aggregate instances by saving the stream of events in order
 * to record changes in the state of the aggregate.
 *
 * Communication and Integration. You can also use events to communicate between
 * aggregates or process managers in the same or in different bounded contexts.
 *
 * Events publish to subscribers information about something that has happened.
 *
 * One event can play both roles: an aggregate may raise an event to record a state change
 * and to notify an aggregate in another bounded context of the change.

 * Events in event sourcing should capture the business intent
 * in addition to the change in state of the aggregate.“
 *
 * „Exploring CQRS and Event Sourcing.“
 * iBooks. https://itunes.apple.com/WebObjects/MZStore.woa/wa/viewBook?id=85A96D9C4AEBE2F2D588B4683CCF608E
 *
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 * @author Manfred Weber <crafics@php.net>
 * @package Iteration\Iteration1
 */
class Iteration1Event extends Message implements EventInterface
{
    /**
     * @var bool
     */
    protected $edited = false;

    /**
     *
     */
    public function edit()
    {
        $this->edited = true;
    }

    /**
     * @return bool
     */
    public function isEdited()
    {
        return $this->edited;
    }
}
