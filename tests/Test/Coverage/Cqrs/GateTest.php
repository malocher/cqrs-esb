<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Cqrs;

use Test\Coverage\Cqrs\Bus\BusInterfaceTest;
use Test\TestCase;

/**
 * Gate
 *
 * @author Manfred Weber <manfred.weber@gmail.com>
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class GateTest extends TestCase {

    /**
     * Singleton instance
     *
     * @var Gate
     */
    private static $instance;

    /**
     * Bus systems
     *
     * @var array
     */
    private $busSystems;

    /**
     *
     * @return Gate
     */
    static public function getInstance()
    {
        /*if (is_null(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;*/
    }

    /**
     * Private constructor
     */
    private function __construct()
    {
        //$this->busSystems = array();
    }

    /**
     * reset singleton
     */
    public function reset()
    {
        /*foreach($this->busSystems as $bus){
            $this->detach($bus);
        }
        $this->busSystems = array();
        return self::getInstance();*/
    }

    private function __clone()
    {
        //Singleton implementation, so clone is not allowed
    }

    public function enableSystemBus()
    {
        /*if( is_null( $this->getBus('system-bus') ) ){
            $systemBus = new SystemBus(
                new ClassMapCommandHandlerLoader(),
                new ClassMapEventListenerLoader()
            );
            try {
                $this->attach($systemBus);
            } catch ( GateException $e ){
                echo $e->getMessage();
            }
        }*/
    }

    public function disableSystemBus()
    {
        //$systemBus = $this->getBus('system-bus');
        //$this->detach( $systemBus );
    }

    public function detach(BusInterfaceTest $bus)
    {
        /*if( isset($this->busSystems[$bus->getName()]) ){
            $this->busSystems[$bus->getName()] = null;
            unset( $this->busSystems[$bus->getName()] );
        }*/
    }

    public function attach(BusInterfaceTest $bus)
    {
        /*$bus->setGate($this);
        if( isset($this->busSystems[$bus->getName()]) ){
            switch( $bus->getName() ){
                case 'system-bus':
                    throw GateException::attachError(sprintf('Bus <%s> is reserved!',$bus->getName()));
                default:
                    throw GateException::attachError(sprintf('Bus <%s> is already attached!',$bus->getName()));
            }
        }
        $this->busSystems[$bus->getName()] = $bus;*/
    }

    /**
     *
     * @param string $name
     * @return BusInterface
     * @throws \Exception
     */
    public function getBus($name)
    {
        /*if(!isset($this->busSystems[$name])){
            return null;
        }
        return $this->busSystems[$name];*/
    }

}