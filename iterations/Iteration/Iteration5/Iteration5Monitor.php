<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Iteration\Iteration5;

use Cqrs\Adapter\AdapterTrait;
use Cqrs\Command\InvokeCommandCommand;
use Cqrs\Command\PublishEventCommand;
use Cqrs\Event\CommandInvokedEvent;
use Cqrs\Event\EventPublishedEvent;

/**
 * Class Iteration5Monitor
 *
 * This Handler class makes use of annotations
 * Note the use of the AdapterTrait which loosely couples this file with the cqrs package
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Iteration\Iteration5
 */
class Iteration5Monitor
{
    use AdapterTrait;

    /**
     * @command Cqrs\Command\InvokeCommandCommand
     * @param InvokeCommandCommand $command
     */
    public function invokeCommandHandler(InvokeCommandCommand $command)
    {
        print"---- monitoring start -----\n";
        print sprintf("InvokeCommandCommand invoked by %s on %s \n",
            $command->getMessageClass(),
            $command->getBusName()
        );
        print sprintf("id:%s, edited:%s, ts:%s, version:%s, arguments:%s \n",
            $command->getMessageVars()['id'],
            $command->getMessageVars()['edited'],
            $command->getMessageVars()['timestamp'],
            $command->getMessageVars()['version'],
            $command->getMessageVars()['arguments']
        );
        print"---- monitoring ends ------\n";
    }

    /**
     * @command Cqrs\Command\PublishEventCommand
     * @param PublishEventCommand $command
     */
    public function publishEventHandler(PublishEventCommand $command)
    {
        print"---- monitoring start -----\n";
        print sprintf("PublishEventCommand invoked by %s on %s \n",
            $command->getMessageClass(),
            $command->getBusName()
        );
        print sprintf("id:%s, edited:%s, ts:%s, version:%s, arguments:%s \n",
            $command->getMessageVars()['id'],
            $command->getMessageVars()['edited'],
            $command->getMessageVars()['timestamp'],
            $command->getMessageVars()['version'],
            $command->getMessageVars()['arguments']
        );
        print"---- monitoring ends ------\n";
    }

    /**
     * @event Cqrs\Event\CommandInvokedEvent
     * @param CommandInvokedEvent $event
     */
    public function commandInvokedHandler(CommandInvokedEvent $event)
    {
        print"---- monitoring start -----\n";
        print sprintf("CommandInvokedEvent published by %s on %s \n",
            $event->getMessageClass(),
            $event->getBusName()
        );
        print sprintf("id:%s, edited:%s, ts:%s, version:%s, arguments:%s \n",
            $event->getMessageVars()['id'],
            $event->getMessageVars()['edited'],
            $event->getMessageVars()['timestamp'],
            $event->getMessageVars()['version'],
            $event->getMessageVars()['arguments']
        );
        print"---- monitoring ends ------\n";
    }

    /**
     * @event Cqrs\Event\EventPublishedEvent
     * @param EventPublishedEvent $event
     */
    public function eventPublishedHandler(EventPublishedEvent $event)
    {
        print"---- monitoring start -----\n";
        print sprintf("EventPublishedEvent published by %s on %s \n",
            $event->getMessageClass(),
            $event->getBusName()
        );
        print sprintf("id:%s, edited:%s, ts:%s, version:%s, arguments:%s \n",
            $event->getMessageVars()['id'],
            $event->getMessageVars()['edited'],
            $event->getMessageVars()['timestamp'],
            $event->getMessageVars()['version'],
            $event->getMessageVars()['arguments']
        );
        print"---- monitoring ends ------\n";
    }
}
