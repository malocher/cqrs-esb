<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Mock\Handler;

use Cqrs\Adapter\AdapterTrait;
use Cqrs\Command\InvokeCommandCommand;
use Cqrs\Command\PublishEventCommand;
use Cqrs\Event\CommandInvokedEvent;
use Cqrs\Event\EventPublishedEvent;
use Cqrs\Annotation\Command;
use Cqrs\Annotation\Event;


class MockSystemBusHandler {

    use AdapterTrait;

    /**
     * @Cqrs\Annotation\Command("Cqrs\Command\InvokeCommandCommand")
     */
    public function dumpInvokeCommandCommand(InvokeCommandCommand $command)
    {
        //var_dump( $command );
    }

    /**
     * @Cqrs\Annotation\Command("Cqrs\Command\PublishEventCommand")
     */
    public function dumpPublishEventCommand(PublishEventCommand $command)
    {
        //var_dump( $command );
    }

    /**
     * @Cqrs\Annotation\Event("Cqrs\Event\CommandInvokedEvent")
     */
    public function dumpCommandInvokedEvent(CommandInvokedEvent $event)
    {
        //var_dump( $event );
    }

    /**
     * @Cqrs\Annotation\Event("Cqrs\Event\EventPublishedEvent")
     */
    public function dumpEventPublishedEvent(EventPublishedEvent $event)
    {
        //var_dump( $event );
    }
}