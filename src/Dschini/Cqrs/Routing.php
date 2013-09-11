<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dschini\Cqrs;

use Dschini\Cqrs\Interfaces\RoutingInterface;

/**
 * Routing
 *
 * @author Manfred Weber <manfred.weber@gmail.com>
 */
class Routing implements RoutingInterface {

    private $gate;

    public function setGate(Gate $gate){
        $this->gate = $gate;
    }

    public function getBus($name){
        return $this->gate->getBus($name);
    }
}