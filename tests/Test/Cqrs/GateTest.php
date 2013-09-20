<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Cqrs;

use Cqrs\Gate;
use Test\TestCase;

class GateTest extends TestCase {

    /**
     * @covers Cqrs\Gate::getInstance
     */
    public function testGateGetInstance(){
        $gate = Gate::getInstance();
        $this->assertInstanceOf("Cqrs\\Gate",$gate);
        return $gate;
    }

    /**
     * @depends testGateGetInstance
     * @covers Cqrs\Gate::getInstance
     */
    public function testGateIsSingleton(Gate $gate){
        $this->assertEquals($gate,Gate::getInstance());
    }

}