<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Mock\Event;

use Cqrs\Adapter\AdapterTrait;
use Cqrs\Event\EventInterface;

/**
 * Class MockEventHandler
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Test\Coverage\Mock\Event
 */
class MockEventHandler
{
    use AdapterTrait;

    /**
     * @param EventInterface $event
     */
    public function handleEvent(EventInterface $event)
    {
        if ($event instanceof MockEvent) {
            $event->edit();
        }
    }

    /**
     * @event Test\Coverage\Mock\Event\MockEvent
     * @param MockEvent $event
     */
    public function handleAnnotationEvent(MockEvent $event)
    {
        if ($event instanceof MockEvent) {
            $event->edit();
        }
    }
}
