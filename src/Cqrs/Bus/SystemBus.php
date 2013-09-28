<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cqrs\Bus;

use Cqrs\Command\CommandInterface;
use Cqrs\Event\EventInterface;

/**
 * Class SystemBus
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Cqrs\Bus
 */
class SystemBus extends AbstractBus
{
    /**
     * get name of the bus
     *
     * @return string
     */
    public function getName()
    {
        return self::SYSTEMBUS;
    }

    /**
     * invoke a command
     *
     * @param \Cqrs\Command\CommandInterface $command
     * @throws BusException
     * @return bool|void
     */
    public function invokeCommand(CommandInterface $command)
    {
        $commandClass = get_class($command);

        if (!isset($this->commandHandlerMap[$commandClass])) {
            return false;
        }

        foreach ($this->commandHandlerMap[$commandClass] as $i => $callableOrDefinition) {

            // @todo how will this work with traits ?
            if (is_callable($callableOrDefinition)) {
                call_user_func($callableOrDefinition, $command);
            }

            if (is_array($callableOrDefinition)) {
                $commandHandler = $this->commandHandlerLoader->getCommandHandler($callableOrDefinition['alias']);
                $method = $callableOrDefinition['method'];

                // instead of invoking the handler method directly
                // we call the execute function of the implemented trait and pass along a reference to the gate
                $usedTraits = class_uses($commandHandler);
                if (!isset($usedTraits['Cqrs\Adapter\AdapterTrait'])) {
                    throw BusException::traitError('Adapter Trait is missing! Use it!');
                }
                $commandHandler->executeCommand($this, $commandHandler, $method, $command);
            }
        }

        return true;
    }

    /**
     * publish a event
     *
     * @param \Cqrs\Event\EventInterface $event
     * @throws BusException
     * @return bool|void
     */
    public function publishEvent(EventInterface $event)
    {
        $eventClass = get_class($event);

        if (!isset($this->eventListenerMap[$eventClass])) {
            return false;
        }

        foreach ($this->eventListenerMap[$eventClass] as $i => $callableOrDefinition) {

            // @todo how will this work with traits ?
            if (is_callable($callableOrDefinition)) {
                call_user_func($callableOrDefinition, $event);
            }

            if (is_array($callableOrDefinition)) {
                $eventListener = $this->eventListenerLoader->getEventListener($callableOrDefinition['alias']);
                $method = $callableOrDefinition['method'];

                // instead of invoking the handler method directly
                // we call the execute function of the implemented trait and pass along a reference to the gate
                $usedTraits = class_uses($eventListener);
                if (!isset($usedTraits['Cqrs\Adapter\AdapterTrait'])) {
                    throw BusException::traitError('Adapter Trait is missing! Use it!');
                }
                $eventListener->executeEvent($this, $eventListener, $method, $event);
            }
        }

        return true;
    }
}