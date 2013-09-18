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
use Cqrs\Command\CommandHandlerInterface;
use Cqrs\Command\CommandHandlerLoaderInterface;

use Cqrs\Event\EventInterface;
use Cqrs\Event\EventListenerInterface;
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
     * Map a command to a command handler
     * 
     * @param string                         $commandOrClass
     * @param CommandHandlerInterface|string $commandHandlerOrAlias
     * 
     * @return void
     */
    public function mapCommand($commandClass, $commandHandlerOrAlias) {
        
        if (!isset($this->commandHandlerMap[$commandClass])) {
            $this->commandHandlerMap[$commandClass] = array();
        }
        
        $this->commandHandlerMap[$commandClass][] = $commandHandlerOrAlias;
    }
    
    /**
     * Hand over command to registered command handler(s)
     * 
     * @param CommandInterface $command
     * 
     * @return array List of success status for each command handler
     */
    public function invokeCommand(CommandInterface $command) {
        $commandClass = get_class($command);
        $successList = array();
        
        foreach($this->commandHandlerMap[$commandClass] as $i => $commandHandlerOrAlias) {
            $commandHandler = $this->getCommandHandler($commandHandlerOrAlias);
            //cache command handler object
            $this->commandHandlerMap[$commandClass][$i] = $commandHandler;
            
            $successList[$commandClass] = $commandHandler->handleCommand($command, $this->gate);
        }
        
        return $successList;
    }
    
    /**
     * Register a listener for an event
     * 
     * @param string                        $eventClass
     * @param EventListenerInterface|string $listenerOrAlias
     * 
     * @return void
     */
    public function registerEventListener($eventClass, $listenerOrAlias) {
        
    }
    
    /**
     * Dispatch an event
     * 
     * @param EventInterface $event
     * 
     * @return void
     */
    public function dispatchEvent(EventInterface $event) {
        
    }
    
    /**
     * If provided argument is a string, then it is treated as an alias is passed
     * to the CommandHandlerLoader to get an instance of the command handler
     * 
     * @param type $commandHandlerOrAlias
     * 
     * @return CommandHandlerInterface
     */
    protected function getCommandHandler($commandHandlerOrAlias) {
        if (is_string($commandHandlerOrAlias)) {
            $commandHandlerOrAlias = $this->commandHandlerLoader->getCommandHandler($commandHandlerOrAlias);
        }
        
        return $commandHandlerOrAlias;
    }
}
