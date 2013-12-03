<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cqrs\Gate;

use Cqrs\Bus\BusInterface;
use Cqrs\Gate;
use Cqrs\Command\CommandInterface;
use Cqrs\Bus\BusException;
use Cqrs\Query\QueryInterface;
use Cqrs\Event\EventInterface;
use Cqrs\Command\InvokeCommandCommand;
use Cqrs\Command\ExecuteQueryCommand;
use Cqrs\Command\PublishEventCommand;
use Cqrs\Event\CommandInvokedEvent;
use Cqrs\Event\EventPublishedEvent;
use Cqrs\Event\QueryExecutedEvent;
/**
 * Class to proxy all bus communication
 *
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 * @package Cqrs\Gate
 */
class BusProxy implements BusInterface
{
    /**
     * @var BusInterface
     */
    protected $bus;
    
    /**
     * @var Gate
     */
    protected $gate;
    
    

    /**
     * Initialze proxy with the target bus
     * 
     * @param BusInterface $bus
     */
    public function __construct(BusInterface $bus) 
    {
        $this->bus = $bus;
    }
    
    public function __call($name, $arguments) {
        return call_user_func_array(array($this->bus, $name), $arguments);
    }
    
    /**
     * {@inheritDoc}
     */
    public function setGate(Gate $gate) 
    {
        $this->gate = $gate;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getGate() 
    {
        return $this->gate;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getName() 
    {
        return $this->bus->getName();
    }
    
    /**
     * {@inheritDoc}
     */
    public function mapCommand($commandClass, $callableOrDefinition) 
    {
        $this->bus->mapCommand($commandClass, $callableOrDefinition);
    }
    
    /**
     * {@inheritDoc}
     */
    public function getCommandHandlerMap() 
    {
        return $this->bus->getCommandHandlerMap();
    }
    
    /**
     * {@inheritDoc}
     */
    public function invokeCommand(CommandInterface $command) 
    {
        $commandClass = get_class($command);

        // InvokeCommandCommand first! Because a commandClass _IS_ actually invoked.
        if (!is_null($this->gate->getSystemBus())) {
            $invokeCommandCommand = new InvokeCommandCommand();
            $invokeCommandCommand->setMessageClass(get_class($command));
            $invokeCommandCommand->setMessageVars($command->getMessageVars());
            $invokeCommandCommand->setBusName($this->getName());
            $this->gate->getSystemBus()->invokeCommand($invokeCommandCommand);
        }
        
        try {
            $response = $this->bus->invokeCommand($command);
            
            if ($response === false) {
                return false;
            }
        } catch (BusException $ex) {
            //throw it again
            throw $ex;
        } catch (\Exception $ex) {
            throw BusException::defaultBusError($ex->getMessage(), null, $ex);
        }
        
        // Dispatch the CommandInvokedEvent here! If for example a command could not be invoked
        // because it does not exist in the commandHandlerMap[<empty>] this Event would never
        // be dispatched!
        if (!is_null($this->gate->getSystemBus())) {
            $commandInvokedEvent = new CommandInvokedEvent();
            $commandInvokedEvent->setMessageClass(get_class($command));
            $commandInvokedEvent->setMessageVars($command->getMessageVars());
            $commandInvokedEvent->setBusName($this->getName());
            $this->gate->getSystemBus()->publishEvent($commandInvokedEvent);
        }
        
        return $response;
    }
    
    /**
     * {@inheritDoc}
     */
    public function mapQuery($queryClass, $callableOrDefinition) 
    {
        $this->bus->mapQuery($queryClass, $callableOrDefinition);
    }
    
    /**
     * {@inheritDoc}
     */
    public function getQueryHandlerMap() 
    {
        return $this->bus->getQueryHandlerMap();
    }
    
    /**
     * {@inheritDoc}
     */
    public function executeQuery(QueryInterface $query) 
    {
        // ExecuteQueryCommand first! Because a queryClass _IS_ actually invoked.
        if (!is_null($this->gate->getSystemBus())) {
            $executeQueryCommand = new ExecuteQueryCommand();
            $executeQueryCommand->setMessageClass(get_class($query));
            $executeQueryCommand->setMessageVars($query->getMessageVars());
            $executeQueryCommand->setBusName($this->getName());
            $this->gate->getSystemBus()->invokeCommand($executeQueryCommand);
        }
        
        try {
            $response = $this->bus->executeQuery($query);
            
            if ($response === false) {
                return false;
            }
        } catch (BusException $ex) {
            //throw it again
            throw $ex;
        } catch (\Exception $ex) {
            throw BusException::defaultBusError($ex->getMessage(), null, $ex);
        }
        
        // Dispatch the QueryExecutedEvent here! If for example a query could not be executed
        // because it does not exist in the queryHandlerMap[<empty>] this Event would never
        // be dispatched!
        if (!is_null($this->gate->getSystemBus())) {
            $queryExecutedEvent = new QueryExecutedEvent();
            $queryExecutedEvent->setMessageClass(get_class($query));
            $queryExecutedEvent->setMessageVars($query->getMessageVars());
            $queryExecutedEvent->setBusName($this->getName());
            $queryExecutedEvent->setResult($response);
            $this->gate->getSystemBus()->publishEvent($queryExecutedEvent);
        }
        
        return $response;
    }
    
    /**
     * {@inheritDoc}
     */
    public function registerEventListener($eventClass, $callableOrDefinition) 
    {
        $this->bus->registerEventListener($eventClass, $callableOrDefinition);
    }

    /**
     * {@inheritDoc}
     */
    public function getEventListenerMap() 
    {
        return $this->bus->getEventListenerMap();
    }    

    /**
     * {@inheritDoc}
     */
    public function publishEvent(EventInterface $event) 
    {        
        // Check if event exists after invoking the PublishEventCommand because
        // the PublishEventCommand tells that a event is dispatched but does not care
        // if it succeeded. Later the EventPublishedEvent can be used to check if a
        // event succeeded.
        if (!is_null($this->gate->getSystemBus())) {
            $publishEventCommand = new PublishEventCommand();
            $publishEventCommand->setMessageClass(get_class($event));
            $publishEventCommand->setMessageVars($event->getMessageVars());
            $publishEventCommand->setBusName($this->getName());
            $this->gate->getSystemBus()->invokeCommand($publishEventCommand);
        }
        
        try {
            $response = $this->bus->publishEvent($event);
            
            if ($response === false) {
                return false;
            }
        } catch (BusException $ex) {
            //throw it again
            throw $ex;
        } catch (\Exception $ex) {
            throw BusException::defaultBusError($ex->getMessage(), null, $ex);
        }
        
        // Dispatch the EventPublishedEvent here! If for example a event could not be dispatched
        // because it does not exist in the eventListenerMap[<empty>] this Event would never
        // be dispatched!
        if (!is_null($this->gate->getSystemBus())) {
            $eventPublishedEvent = new EventPublishedEvent();
            $eventPublishedEvent->setMessageClass(get_class($event));
            $eventPublishedEvent->setMessageVars($event->getMessageVars());
            $eventPublishedEvent->setBusName($this->getName());
            $this->gate->getSystemBus()->publishEvent($eventPublishedEvent);
        }
        
        return $response;
    }
}
