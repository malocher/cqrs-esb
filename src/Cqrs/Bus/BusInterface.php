<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cqrs\Bus;

use Cqrs\Gate;
use Cqrs\Command\CommandInterface;
use Cqrs\Event\EventInterface;
use Cqrs\Query\QueryInterface;

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
     * A callable gets two arguments: the command to execute and the gate.
     * A normal class provided as definition should implement the \Cqrs\Adapter\AdapterTrait
     * and only gets the command as argument.
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
     * Map a query to a query handler
     *
     * You can provide every callable as query handler or a definition array,
     * that contains the keys: alias and method.
     *
     * @example defintion:
     *
     * $userQueryHandlerDefinition = array(
     *      'alias'  => 'user_handler',        //Alias is passed to QueryHandlerLoader
     *      'method' => 'handleGetUserQuery' //Method is called after loading QueryHandler
     * );
     *
     * A callable gets two arguments the query to execute and the gate.
     * A normal class provided as definition should implement the \Cqrs\Adapter\AdapterTrait
     * and only gets the query as argument.
     *
     * Both (callable or definition) must return the result of the query.
     *
     * @param $queryClass
     * @param $callableOrDefinition
     * @return mixed
     */
    public function mapQuery($queryClass, $callableOrDefinition);

    /**
     * Get all mapped queries
     *
     * @return mixed
     */
    public function getQueryHandlerMap();

    /**
     * Hand over query to registered query handler(s) and return result
     *
     * The bus should loop over the QueryHandlerMap until a valid result is returned (not null)
     * by a handler or each handler has executed the query
     *
     * @param QueryInterface $query
     * @return mixed|null
     */
    public function executeQuery(QueryInterface $query);

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