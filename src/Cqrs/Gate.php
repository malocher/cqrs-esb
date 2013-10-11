<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cqrs;

use Cqrs\Bus\AbstractBus;
use Cqrs\Bus\BusInterface;
use Cqrs\Bus\SystemBus;
use Cqrs\Command\ClassMapCommandHandlerLoader;
use Cqrs\Event\ClassMapEventListenerLoader;
use Cqrs\Gate\GateException;
use Cqrs\Query\ClassMapQueryHandlerLoader;

/**
 * Class Gate
 *
 * @author Manfred Weber <crafics@php.net>
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 * @package Cqrs
 */
class Gate
{
    /**
     * Buses
     *
     * @var AbstractBus[] $buses
     */
    private $buses;
    
    /**
     * Name of the default bus that should be returned when {@see getBus} is called
     * 
     * @var string
     */
    private $defaultBusName;
    
    /**
     * System bus
     * 
     * If activated, meta commands and events are send over it
     * 
     * @var type 
     */
    private $systemBus;

    /**
     * Private constructor
     */
    public function __construct()
    {
        $this->buses = array();
    }

    /**
     * @return $this
     */
    public function reset()
    {
        foreach ($this->buses as $bus) {
            if ($bus->getName() === AbstractBus::SYSTEMBUS) {
                continue;
            }
            $this->detach($bus);
        }
        return $this;
    }

    /**
     * enable system bus
     */
    public function enableSystemBus()
    {
        if (is_null($this->getBus(AbstractBus::SYSTEMBUS))) {
            $systemBus = new SystemBus(
                new ClassMapCommandHandlerLoader(),
                new ClassMapEventListenerLoader(),
                new ClassMapQueryHandlerLoader()
            );
            $this->attach($systemBus);
        }
    }

    /**
     * @return BusInterface
     */
    public function getSystemBus()
    {
        return $this->getBus(AbstractBus::SYSTEMBUS);
    }

    /**
     * disable system bus
     */
    public function disableSystemBus()
    {
        $systemBus = $this->getSystemBus();
        if (isset($systemBus)) {
            $this->detach($systemBus);
        };
    }

    /**
     * detach bus
     *
     * @param BusInterface $bus
     */
    public function detach(BusInterface $bus)
    {
        if ($bus == $this->systemBus) {
            $this->systemBus = null;
            return;
        }
        
        if (isset($this->buses[$bus->getName()])) {
            $this->buses[$bus->getName()] = null;
            unset($this->buses[$bus->getName()]);
        }
    }

    /**
     * get attached buses
     *
     * @return array
     */
    public function attachedBuses()
    {
        return $this->buses;
    }

    /**
     * attach bus
     *
     * @param BusInterface $bus
     * @throws Gate\GateException
     */
    public function attach(BusInterface $bus)
    {
        $bus->setGate($this);
        
        if ($bus->getName() == AbstractBus::SYSTEMBUS) {
            if (!$bus instanceof SystemBus) {
                throw GateException::attachError(sprintf('Bus <%s> is reserved!', $bus->getName()));
            }
            
            if (!is_null($this->systemBus)) {
                throw GateException::attachError('SystemBus is already attached!');
            }
            
            $this->systemBus = $bus;
            return;
        }
        
        if (isset($this->buses[$bus->getName()])) {
            throw GateException::attachError(sprintf('Bus <%s> is already attached!', $bus->getName()));
        }
        
        $this->buses[$bus->getName()] = $bus;
    }

    /**
     * get bus by name
     * 
     * If no name is provided, the gate tries to find a default bus:
     *   1. you can set a default bus via {@see setDefaultBusName}
     *   2. if only one bus is attached, it is treated as default bus
     *
     * @param string $name
     * @return BusInterface|null If the system bus is requested but not enabled, method returns null
     * @throws Bus\BusException If default bus can not be detected or bus not exists
     */
    public function getBus($name = null)
    {
        if ($name == AbstractBus::SYSTEMBUS) {
            return $this->systemBus;
        }
        
        if (is_null($name)) {
            if (!is_null($this->defaultBusName)) {
                $name = $this->defaultBusName;
            } else if (count($this->buses) == 1) {
                return current($this->buses);
            } else {
                throw Bus\BusException::defaultBusError(
                    'Default bus can not be detected. Please set the default bus or provide a bus name'
                );
            }
        } 
        
        if (!isset($this->buses[$name])) {
            throw Bus\BusException::busNotExistError(
                sprintf(
                    'The bus <%s> can not be found',
                    $name
                )
            );
        }

        return $this->buses[$name];
         
    }
    
    /**
     * Set name of the default bus
     * 
     * If you have more than one bus attached to the gate,
     * you can set one as default, this bus is then returned when you call
     * {@see getBus} without providing a bus name
     * 
     * @param string $busName
     * @return void
     */
    public function setDefaultBusName($busName) {
        $this->defaultBusName = $busName;
    }

}