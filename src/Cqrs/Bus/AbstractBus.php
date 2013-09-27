<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cqrs\Bus;

use Cqrs\Bus\BusException;
use Cqrs\Command\CommandInvokedCommand;
use Cqrs\Command\InvokeCommandCommand;
use Cqrs\Command\PublishEventCommand;
use Cqrs\Event\CommandInvokedEvent;
use Cqrs\Event\EventPublishedEvent;
use Cqrs\Gate;
use Cqrs\Gate\GateException;
use Cqrs\Command\CommandInterface;
use Cqrs\Command\CommandHandlerLoaderInterface;

use Cqrs\Event\EventInterface;
use Cqrs\Event\EventListenerLoaderInterface;
/**
 * AbstractBus
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
abstract class AbstractBus implements BusInterface
{
    /**
     *
     * @var CommandHandlerLoaderInterface 
     */
    protected $commandHandlerLoader;
    
    /**
     *
     * @var EventListenerLoaderInterface 
     */
    protected $eventListenerLoader;
    
    /**
     *
     * @var array
     */
    protected $commandHandlerMap = array();

    /**
     *
     * @var array
     */
    protected $eventListenerMap  = array();

    /**
     *
     * @var Gate
     */
    protected $gate;
    
    /**
     * Constructor
     * 
     * @param CommandHandlerLoaderInterface $commandHandlerLoader
     * @param EventListenerLoaderInterface $eventListenerLoader
     */
    public function __construct(
        CommandHandlerLoaderInterface $commandHandlerLoader,
        EventListenerLoaderInterface $eventListenerLoader) {
        
        $this->commandHandlerLoader = $commandHandlerLoader;
        $this->eventListenerLoader  = $eventListenerLoader;
    }

    /**
     * Set the gate where the bus is registered on
     *
     * @param Gate $gate
     */
    public function setGate(Gate $gate) {
        $this->gate = $gate;
    }

    /**
     * Get the gate where the bus is registered on
     *
     * @return Gate $gate
     */
    public function getGate() {
        return $this->gate;
    }

    /**
     * {@inheritDoc}
     */
    public function mapCommand($commandClass, $callableOrDefinition)
    {
        if (!isset($this->commandHandlerMap[$commandClass])) {
            $this->commandHandlerMap[$commandClass] = array();
        }
        $this->commandHandlerMap[$commandClass][] = $callableOrDefinition;
    }

    /**
     * {@inheritDoc}
     */
    public function getCommandHandlerMap()
    {
        return $this->commandHandlerMap;
    }

    /**
     * {@inheritDoc}
     */
    public function invokeCommand(CommandInterface $command)
    {
        $commandClass = get_class($command);

        /*
         * InvokeCommandCommand first! Because a commandClass _IS_ actually invoked.
         */
        if( !is_null($this->gate->getBus('system-bus')) ){
            $invokeCommandCommand = new InvokeCommandCommand();
            $invokeCommandCommand->setClass($commandClass);
            $invokeCommandCommand->setId($command->getId());
            $invokeCommandCommand->setTimestamp($command->getTimestamp());
            $invokeCommandCommand->setArguments($command->getArguments());
            $this->gate->getBus('system-bus')->invokeCommand($invokeCommandCommand);
        }

        /*
         * Check if command exists after invoking the InvokeCommandCommand because
         * the InvokeCommandCommand tells that a command is invoked but does not care
         * if it succeeded. Later the CommandInvokedEvent can be used to check if a
         * command succeeded.
         */
        if( !isset($this->commandHandlerMap[$commandClass]) ){
            return;
        }

        foreach($this->commandHandlerMap[$commandClass] as $i => $callableOrDefinition) {
            
            if (is_callable($callableOrDefinition)) {
                call_user_func($callableOrDefinition, $command, $this->gate);
            }

            if (is_array($callableOrDefinition)) {
                $commandHandler = $this->commandHandlerLoader->getCommandHandler($callableOrDefinition['alias']);
                $method = $callableOrDefinition['method'];

                /* instead of invoking the handler method directly
                 * we call the execute function of the implemented trait and pass along a reference to the gate
                 */
                $usedTraits = class_uses($commandHandler);
                if( !isset($usedTraits['Cqrs\Adapter\AdapterTrait']) ){
                    throw BusException::traitError('Adapter Trait is missing! Use it!');
                }
                $commandHandler->executeCommand($this->gate,$commandHandler,$method,$command);                
            }
        }

        /*
         * Dispatch the CommandInvokedEvent here! If for example a command could not be invoked
         * because it does not exist in the commandHandlerMap[<empty>] this Event would never
         * be dispatched!
         */
        if( !is_null($this->gate->getBus('system-bus')) ){
            $commandInvokedEvent = new CommandInvokedEvent();
            $commandInvokedEvent->setClass($commandClass);
            $commandInvokedEvent->setId($command->getId());
            $commandInvokedEvent->setTimestamp($command->getTimestamp());
            $commandInvokedEvent->setArguments($command->getArguments());
            $this->gate->getBus('system-bus')->publishEvent($commandInvokedEvent);
        }
    }
    
    /**
     * {@inheritDoc}
     */
    public function registerEventListener($eventClass, $callableOrDefinition)
    {
        if (!isset($this->eventListenerMap[$eventClass])) {
            $this->eventListenerMap[$eventClass] = array();
        }
        $this->eventListenerMap[$eventClass][] = $callableOrDefinition;
    }

    /**
     * {@inheritDoc}
     */
    public function getEventListenerMap()
    {
        return $this->eventListenerMap;
    }
    
    /**
     * {@inheritDoc}
     */
    public function publishEvent(EventInterface $event)
    {
        $eventClass = get_class($event);

        /*
         * Check if event exists after invoking the PublishEventCommand because
         * the PublishEventCommand tells that a event is dispatched but does not care
         * if it succeeded. Later the EventPublishedEvent can be used to check if a
         * event succeeded.
         */
        if( !is_null($this->gate->getBus('system-bus')) ){
            $publishEventCommand = new PublishEventCommand();
            $publishEventCommand->setClass($eventClass);
            $publishEventCommand->setId($event->getId());
            $publishEventCommand->setTimestamp($event->getTimestamp());
            $publishEventCommand->setArguments($event->getArguments());
            $this->gate->getBus('system-bus')->invokeCommand($publishEventCommand);
        }

        if(!isset($this->eventListenerMap[$eventClass])){
            return;
        }

        foreach($this->eventListenerMap[$eventClass] as $i => $callableOrDefinition) {
            if (is_callable($callableOrDefinition)) {
                call_user_func($callableOrDefinition, $event);
            }

            if (is_array($callableOrDefinition)) {
                $eventListener = $this->eventListenerLoader->getEventListener($callableOrDefinition['alias']);
                $method = $callableOrDefinition['method'];

                /* instead of invoking the handler method directly
                 * we call the execute function of the implemented trait and pass along a reference to the gate
                 */
                $usedTraits = class_uses($eventListener);
                if( !isset($usedTraits['Cqrs\Adapter\AdapterTrait']) ){
                    throw BusException::traitError('Adapter Trait is missing! Use it!');
                }
                $eventListener->executeEvent($this->gate,$eventListener,$method,$event);
            }
        }

        /*
         * Dispatch the EventPublishedEvent here! If for example a event could not be dispatched
         * because it does not exist in the eventListenerMap[<empty>] this Event would never
         * be dispatched!
         */
        if( !is_null($this->gate->getBus('system-bus')) ){
            $eventPublishedEvent = new EventPublishedEvent();
            $eventPublishedEvent->setClass($eventClass);
            $eventPublishedEvent->setId($event->getId());
            $eventPublishedEvent->setTimestamp($event->getTimestamp());
            $eventPublishedEvent->setArguments($event->getArguments());
            $this->gate->getBus('system-bus')->publishEvent($eventPublishedEvent);
        }
    }
}
