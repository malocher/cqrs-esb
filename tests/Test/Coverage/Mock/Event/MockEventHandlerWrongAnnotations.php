<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Mock\Event;

use Malocher\Cqrs\Adapter\AdapterTrait;
use Malocher\Cqrs\Event\EventInterface;

/**
 * Class MockEventHandlerWrongAnnotations
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Test\Coverage\Mock\Event
 */
class MockEventHandlerWrongAnnotations
{
    /**
     * @event Test\Coverage\Mock\Event\NonExistingMockEvent
     * @param EventInterface $event
     */
    public function handleNonExistingAnnotationEvent(EventInterface $event)
    {
    }
}
