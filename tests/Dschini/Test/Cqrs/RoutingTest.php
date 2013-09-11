<?php
/**
 * Created by JetBrains PhpStorm.
 * User: manfredweber
 * Date: 11.09.13
 * Time: 21:27
 * To change this template use File | Settings | File Templates.
 */

namespace Dschini\Test\Cqrs;


use Dschini\Cqrs\Gate;
use Dschini\Cqrs\Routing;
use Dschini\Test\TestCase;

class RoutingTest extends TestCase {

    public function testInitRouting(){
        $routing = new Routing();
        $this->assertInstanceOf('Dschini\Cqrs\Interfaces\RoutingInterface',$routing);
        return $routing;
    }

    /**
     * @depends testInitRouting
     */
    public function testSetGate(Routing $routing){
        $gate = new Gate($routing);
        $this->assertEquals($routing,$gate->getRouting());
        return $gate;
    }

    /**
     * @depends testSetGate
     */
    public function testGetNonExistentBus(Gate $gate){
        $this->setExpectedException('Exception');
        $gate->getBus("test");
    }

}