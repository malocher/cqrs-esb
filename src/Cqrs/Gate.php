<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cqrs;

use Cqrs\Gate\GateException;
use Cqrs\Bus\BusInterface;
use Cqrs\Bus\SystemBus;
use Cqrs\Command\ClassMapCommandHandlerLoader;
use Cqrs\Event\ClassMapEventListenerLoader;

/**
 * Gate
 *
 * @author Manfred Weber <manfred.weber@gmail.com>
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class Gate {

    /**
     * Bus systems
     *
     * @var array
     */
    private $buses;

    /**
     * Private constructor
     */
    public function __construct()
    {
        $this->buses = array();
    }

    /**
     * reset singleton
     */
    public function reset()
    {
        foreach($this->buses as $bus){
            $this->detach($bus);
        }
        $this->buses = array();
        //return self::getInstance();
        return $this; //self::getInstance();
    }

    private function __clone()
    {
        //Singleton implementation, so clone is not allowed
    }

    public function enableSystemBus()
    {
        if( is_null( $this->getBus('system-bus') ) ){
            $systemBus = new SystemBus(
                new ClassMapCommandHandlerLoader(),
                new ClassMapEventListenerLoader()
            );
            try {
                $this->attach($systemBus);
            } catch ( GateException $e ){
                echo $e->getMessage();
            }
        }
    }

    public function disableSystemBus()
    {
        $systemBus = $this->getBus('system-bus');
        if( isset($systemBus)){
            $this->detach( $systemBus );
        };
    }

    public function detach(BusInterface $bus)
    {
        if( isset($this->buses[$bus->getName()]) ){
            $this->buses[$bus->getName()] = null;
            unset( $this->buses[$bus->getName()] );
        }
    }

    public function attachedBuses()
    {
        return $this->buses;
    }

    public function attach(BusInterface $bus)
    {
        $bus->setGate($this);
        if( isset($this->buses[$bus->getName()]) ){
            switch( $bus->getName() ){
                case 'system-bus':
                    throw GateException::attachError(sprintf('Bus <%s> is reserved!',$bus->getName()));
                default:
                    throw GateException::attachError(sprintf('Bus <%s> is already attached!',$bus->getName()));
            }
        }
        $this->buses[$bus->getName()] = $bus;
    }

    /**
     * 
     * @param string $name
     * @return BusInterface
     * @throws \Exception
     */
    public function getBus($name)
    {
        if(!isset($this->buses[$name])){
            return null;
        }
        return $this->buses[$name];
    }

}