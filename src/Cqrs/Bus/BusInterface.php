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
     * @param string                         $commandOrClass
     * @param CommandHandlerInterface|string $commandHandlerOrAlias
     * 
     * @return void
     */
    public function mapCommand($commandClass, $commandHandlerOrAlias);
    
    /**
     * Hand over command to registered command handler(s)
     * 
     * @example:
     * 
     * $successList = $bus->invokeCommand(new CreateUserCommand(array('name' => 'John Doe')));
     * //$successList = array(
     * //   'user_command_handler' => true,
     * //   'password_generator'   => true,
     * //)
     * 
     * @param CommandInterface $command
     * @return array List of success status for each command handler
     */
    public function invokeCommand(CommandInterface $command);
    
    /**
     * Register a listener for an event
     * 
     * @param string                        $eventClass
     * @param EventListenerInterface|string $listenerOrAlias
     * 
     * @return void
     */
    public function registerEventListener($eventClass, $listenerOrAlias);
    
    /**
     * Dispatch an event
     * 
     * @param EventInterface $event
     * 
     * @return void
     */
    public function dispatchEvent(EventInterface $event);
}