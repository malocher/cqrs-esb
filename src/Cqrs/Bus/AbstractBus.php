<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cqrs\Bus;

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
            if (is_callable($callableOrDefinition)) {
                call_user_func($callableOrDefinition, $command, $this->gate);
                return;
            }
            
            if (is_array($callableOrDefinition)) {
                $commandHandler = $this->commandHandlerLoader->getCommandHandler($callableOrDefinition['alias']);
                $method = $callableOrDefinition['method'];
                $commandHandler->{$method}($command, $this->gate);
                return;
            }
        }
    }
    
    /**
     * {@inheritDoc}
     */
    public function registerEventListener($eventClass, $callableOrDefinition) {
        if (!isset($this->eventListenerMap[$eventClass])) {
            $this->commandHandlerMap[$eventClass] = array();
        }
        
        $this->eventListenerMap[$eventClass][] = $callableOrDefinition;
    }
    
    /**
     * {@inheritDoc}
     */
    public function publishEvent(EventInterface $event) {
        $eventClass = get_class($event);
        
        foreach($this->eventListenerMap[$eventClass] as $i => $callableOrDefinition) {
            if (is_callable($callableOrDefinition)) {
                call_user_func($callableOrDefinition, $event);
                return;
            }
            
            if (is_array($callableOrDefinition)) {
                $eventListener = $this->eventListenerLoader->getEventListener($callableOrDefinition['alias']);
                $method = $callableOrDefinition['method'];
                $eventListener->{$method}($event);
                return;
            }
        }
    }
}
