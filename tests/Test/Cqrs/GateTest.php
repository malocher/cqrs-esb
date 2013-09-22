<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Cqrs;

use Cqrs\Bus\BusInterface;
use Cqrs\Bus\SystemBus;
use Cqrs\Command\ClassMapCommandHandlerLoader;
use Cqrs\Event\ClassMapEventListenerLoader;
use Cqrs\Gate;
use Test\Mock\Bus\BusGateTestsMock;
use Test\TestCase;

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
        $this->busGateTestsMock = new BusGateTestsMock($classMapCommandHandlerLoader,$classMapEventListenerLoader);
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
        $this->gate->attach($this->busGateTestsMock);
        $this->assertEquals( $this->gate->getBus("mock-gate-tests-bus"), $this->busGateTestsMock );
    }

    /**
     * @depends testCreateAttach
     * @covers Cqrs\Gate::attach
     */
    public function testBusAlreadyAttachd()
    {
        $this->setExpectedException('Cqrs\Gate\GateException');
        $classMapCommandHandlerLoader = new ClassMapCommandHandlerLoader();
        $classMapEventListenerLoader = new ClassMapEventListenerLoader();
        $anotherBusGateTestsMock = new BusGateTestsMock($classMapCommandHandlerLoader,$classMapEventListenerLoader);
        $this->gate->attach($anotherBusGateTestsMock);
    }

    /**
     * @depends testCreateAttach
     * @covers Cqrs\Gate::attach
     */
    public function testSystemBusAttached()
    {
        $this->gate->enableSystemBus();
        $this->assertInstanceOf('Cqrs\Bus\SystemBus',$this->gate->getBus('system-bus'));
    }

    /**
     * @depends testCreateAttach
     * @covers Cqrs\Gate::attach
     */
    public function testattachAnotherSystemBus()
    {
        $this->setExpectedException('Cqrs\Gate\GateException');
        $classMapCommandHandlerLoader = new ClassMapCommandHandlerLoader();
        $classMapEventListenerLoader = new ClassMapEventListenerLoader();
        $anotherSystemBus = new SystemBus($classMapCommandHandlerLoader,$classMapEventListenerLoader);
        $this->gate->attach($anotherSystemBus);
    }

}