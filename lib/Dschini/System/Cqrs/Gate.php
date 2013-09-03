<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dschini\System\Cqrs;

/**
 * Gate
 *
 * @author Manfred Weber <manfred.weber@gmail.com>
 */
class Gate {

    private $busSystems;
    private $routing;

    public function __construct(Routing $routing){
        $this->busSystems = array();
        $this->routing = $routing;
        $routing->setGate($this);
    }

    public function pipe(Bus $bus){
        $bus->gate = $this;
        $this->busSystems[$bus->name] = $bus;
    }

    public function getRouting(){
        return $this->routing;
    }

    public function getBus($name){
        if(!isset($this->busSystems[$name])){
            throw new Exception(sprintf("Bus [%s] does not exists",$name));
        }
        return $this->busSystems[$name];
    }

}