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
 * BusInterfaces
 *
 * @author Manfred Weber <manfred.weber@gmail.com>
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
interface BusInterface {
    
    /**
     * Constructor
     * 
     * @param CommandHandlerLoaderInterface $commandHandlerLoader
     * @param EventListenerLoaderInterface $eventListenerLoader
     */
    public function __construct(
        CommandHandlerLoaderInterface $commandHandlerLoader,
        EventListenerLoaderInterface $eventListenerLoader);
    
    /**
     * Get the name of the bus
     * 
     * @return string
     */
    public function getName();
    
    /**
     * Set the gate where the bus is registered on
     * 
     * @param Gate $gate
     */
    public function setGate(Gate $gate);
    
    /**
     * Map a command to a command handler
     * 
     * You can provide every callable as command handler or a definition array,
     * that contains the keys alias and method.
     * 
     * @example defintion:
     * 
     * $userCommandHandlerDefinition = array(
     *      'alias'  => 'user_handler',        //Alias is passed to CommandHandlerLoader
     *      'method' => 'handleAddUserCommand' //Method is called after loading CommandHandler  
     * );
     * 
     * The method that handles a command gets two arguments.
     * The first one is the command and the second is the gate.
     * 
     * @param string         $commandClass
     * @param callable|array $callableOrDefinition
     * 
     * @return void
     */
    public function mapCommand($commandClass, $callableOrDefinition);
    
    /**
     * Hand over command to registered command handler(s)
     *
     * @param CommandInterface $command
     * @param int $maxRecursion
     * @return void
     */
    public function invokeCommand(CommandInterface $command);
    
    /**
     * Register a listener for an event
     * 
     * You can provide every callable as event listener or a definition array,
     * that contains the keys alias and method.
     * 
     * @example defintion:
     * 
     * $userAddedEventListenerDefinition = array(
     *      'alias'  => 'password_generator', //Alias is passed to EventListenerLoader
     *      'method' => 'onUserAdded'         //Method is called after loading the EventListener  
     * );
     * 
     * @param string         $eventClass
     * @param callable|array $callableOrDefinition
     * 
     * @return void
     */
    public function registerEventListener($eventClass, $callableOrDefinition);
    
    /**
     * Publish an event
     * 
     * @param EventInterface $event
     * @param int $maxRecursion
     * @return void
     */
    public function publishEvent(EventInterface $event);
}