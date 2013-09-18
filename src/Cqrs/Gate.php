<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cqrs;

use Cqrs\Bus\BusInterface;

/**
 * Gate
 *
 * @author Manfred Weber <manfred.weber@gmail.com>
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class Gate {
    
    /**
     * Singleton instance
     * 
     * @var Gate
     */
    private static $instance;

    private $busSystems;
    
    /**
     * 
     * @return Gate
     */
    static public function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }
        
        return static::$instance;
    }

    /**
     * Private constructor
     */
    private function __construct(){
        $this->busSystems = array();
    }
    
    private function __clone()
    {
        //Singleton implementation, so clone is not allowed
    }

    public function pipe(BusInterface $bus){
        $bus->setGate($this);
        $this->busSystems[$bus->getName()] = $bus;
    }

    /**
     * 
     * @param string $name
     * @return BusInterface
     * @throws \Exception
     */
    public function getBus($name){
        if(!isset($this->busSystems[$name])){
            throw new \Exception(sprintf("Bus [%s] does not exists",$name));
        }
        return $this->busSystems[$name];
    }

}