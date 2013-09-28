<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cqrs\Bus;

use Cqrs\Command\CommandHandlerLoaderInterface;
use Cqrs\Command\CommandInterface;
use Cqrs\Event\EventInterface;
use Cqrs\Event\EventListenerLoaderInterface;
use Cqrs\Gate;

/**
 * Interface BusInterface
 *
 * @author Manfred Weber <crafics@php.net>
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 * @package Cqrs\Bus
 */
interface BusInterface
{
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
     * Get the gate where the bus is registered on
     *
     * @return Gate $gate
     */
    public function getGate();

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
     * @param $commandClass
     * @param $callableOrDefinition
     * @return mixed
     */
    public function mapCommand($commandClass, $callableOrDefinition);

    /**
     * Get all mapped commands
     *
     * @return mixed
     */
    public function getCommandHandlerMap();

    /**
     * Hand over command to registered command handler(s)
     *
     * @param CommandInterface $command
     * @return mixed
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
     * @param $eventClass
     * @param $callableOrDefinition
     * @return mixed
     */
    public function registerEventListener($eventClass, $callableOrDefinition);

    /**
     * @return mixed
     */
    public function getEventListenerMap();

    /**
     * @param EventInterface $event
     * @return mixed
     */
    public function publishEvent(EventInterface $event);
}