<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Cqrs;

use Test\TestCase;

use Cqrs\Command\ClassMapCommandHandlerLoader;
use Cqrs\Event\ClassMapEventListenerLoader;
use Cqrs\Gate;

class GateTest extends TestCase {

    /**
     * @var Gate
     */
    private $gate;

    /**
     * @var BusGateTestsMock
     */
    private $busGateTestsMock;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->gate = Gate::getInstance();
        $classMapCommandHandlerLoader = new ClassMapCommandHandlerLoader();
        $classMapEventListenerLoader = new ClassMapEventListenerLoader();
        //$this->busGateTestsMock = new BusGateTestsMock($classMapCommandHandlerLoader,$classMapEventListenerLoader);
    }

    /**
     * @covers Cqrs\Gate::getInstance
     */
    public function testGateGetInstance(){
        $this->assertInstanceOf("Cqrs\\Gate",$this->gate);
    }

    /**
     * @depends testGateGetInstance
     * @covers Cqrs\Gate::getInstance
     */
    public function testGateIsSingleton(){
        $this->assertEquals($this->gate,Gate::getInstance());
    }

    /**
     * @depends testGateGetInstance
     * @covers Cqrs\Gate::attach
     */
    public function testCreateAttach()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @depends testCreateAttach
     * @covers Cqrs\Gate::attach
     */
    public function testBusAlreadyAttachd()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @depends testCreateAttach
     * @covers Cqrs\Gate::attach
     */
    public function testSystemBusAttached()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @depends testCreateAttach
     * @covers Cqrs\Gate::attach
     */
    public function testAttachAnotherSystemBus()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

}