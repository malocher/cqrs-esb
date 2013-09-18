<?php
/**
 * Created by JetBrains PhpStorm.
 * User: manfredweber
 * Date: 11.09.13
 * Time: 21:27
 * To change this template use File | Settings | File Templates.
 */

namespace Test\Cqrs;


use Cqrs\Gate;
use Test\TestCase;

class GateTest extends TestCase {

    public function testGateGetInstance(){
        $gate = Gate::getInstance();
        $this->assertInstanceOf("Cqrs\\Gate",$gate);
        return $gate;
    }

    /**
     * @depends testGateGetInstance
     */
    public function testGateIsSingleton(Gate $gate){
        $this->assertEquals($gate,Gate::getInstance());
    }

}