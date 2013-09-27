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

class MockEventHandlerWrongAnnotations
{
    /**
     * @Cqrs\Annotation\Event("Test\Coverage\Mock\Event\NonExistingMockEvent")
     */
    public function handleNonExistingAnnotationEvent(EventInterface $event)
    {
        if ($event instanceof MockEvent) {
            $event->edit();
        }
    }
}
