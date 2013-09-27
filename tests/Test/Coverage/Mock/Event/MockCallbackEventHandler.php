<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Mock\Event;

use Cqrs\Adapter\AdapterTrait;
use Cqrs\Event\EventInterface;

class MockCallbackEventHandler
{
    use AdapterTrait;

    public function handleEvent(EventInterface $event)
    {
        if ($event instanceof MockEvent) {
            $event->edit();
        }
    }

    /**
     * @Cqrs\Annotation\Event("Test\Coverage\Mock\Event\MockEvent")
     */
    public function handleAnnotationEvent(EventInterface $event)
    {
        if ($event instanceof MockEvent) {
            $event->edit();
        }
    }
}
