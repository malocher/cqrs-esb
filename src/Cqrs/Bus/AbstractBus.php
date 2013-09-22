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
use Cqrs\Gate;
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
     * {@inheritDoc}
     */
    public function mapCommand($commandClass, $callableOrDefinition) {
        if (!isset($this->commandHandlerMap[$commandClass])) {
            $this->commandHandlerMap[$commandClass] = array();
        }

        $this->commandHandlerMap[$commandClass][] = $callableOrDefinition;
    }
    
    /**
     * {@inheritDoc}
     */
    public function invokeCommand(CommandInterface $command) {
        $commandClass = get_class($command);
        foreach($this->commandHandlerMap[$commandClass] as $i => $callableOrDefinition) {

             // @todo how will this work with traits ?

             if (is_callable($callableOrDefinition)) {
                call_user_func($callableOrDefinition, $command);
                //return;
            }

            if (is_array($callableOrDefinition)) {
                $commandHandler = $this->commandHandlerLoader->getCommandHandler($callableOrDefinition['alias']);
                $method = $callableOrDefinition['method'];

                /* instead of invoking the handler method directly
                 * we call the execute function of the implemented trait and pass along a reference to the gate
                 */
                if( !isset(class_uses($commandHandler)['Cqrs\Adapter\AdapterTrait']) ){
                    throw BusException::traitError('Adapter Trait is missing! Use it!');
                }
                $commandHandler->executeCommand($this->gate,$commandHandler,$method,$command);
                //$commandHandler->{$method}($command);
                //return;
            }
        }
    }
    
    /**
     * {@inheritDoc}
     */
    public function registerEventListener($eventClass, $callableOrDefinition) {
        if (!isset($this->eventListenerMap[$eventClass])) {
            $this->eventListenerMap[$eventClass] = array();
        }

        $this->eventListenerMap[$eventClass][] = $callableOrDefinition;
    }
    
    /**
     * {@inheritDoc}
     */
    public function publishEvent(EventInterface $event) {
        $eventClass = get_class($event);
        if(!isset($this->eventListenerMap[$eventClass])){
            return;
        }
        foreach($this->eventListenerMap[$eventClass] as $i => $callableOrDefinition) {
            if (is_callable($callableOrDefinition)) {
                call_user_func($callableOrDefinition, $event);
                //return;
            }

            if (is_array($callableOrDefinition)) {
                $eventListener = $this->eventListenerLoader->getEventListener($callableOrDefinition['alias']);
                $method = $callableOrDefinition['method'];

                /* instead of invoking the handler method directly
                 * we call the execute function of the implemented trait and pass along a reference to the gate
                 */
                if( !isset(class_uses($eventListener)['Cqrs\Adapter\AdapterTrait']) ){
                    throw BusException::traitError('Adapter Trait is missing! Use it!');
                }
                $eventListener->executeEvent($this->gate,$eventListener,$method,$event);
                //$eventListener->{$method}($event);
                //return;
            }
        }
    }
}
