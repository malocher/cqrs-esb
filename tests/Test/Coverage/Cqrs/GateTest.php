<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Cqrs;

use Cqrs\Command\ClassMapCommandHandlerLoader;
use Cqrs\Event\ClassMapEventListenerLoader;
use Cqrs\Gate;
use Cqrs\Query\ClassMapQueryHandlerLoader;
use Test\Coverage\Mock\Bus\MockBus;
use Test\Coverage\Mock\Bus\MockFakeSystemBus;
use Test\TestCase;

/**
 * Class GateTest
 *
 * @author Manfred Weber <crafics@php.net>
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 * @package Test\Coverage\Cqrs
 */
class GateTest extends TestCase
{
    /**
     * @var Gate
     */
    private $gate;

    public function setUp()
    {
        $this->gate = new Gate();
    }

    public function testConstructed()
    {
        $this->assertInstanceOf('Cqrs\Gate', $this->gate);
    }

    public function testReset()
    {
        $mockBus = new MockBus(
            new ClassMapCommandHandlerLoader(),
            new ClassMapEventListenerLoader(),
            new ClassMapQueryHandlerLoader()
        );
        $this->gate->attach($mockBus);
        $this->gate->reset();
        $attachedBuses = $this->gate->attachedBuses();
        $this->assertEquals(0, count($attachedBuses));
    }

    public function testResetSystemBus()
    {
        $this->gate->enableSystemBus();
        $this->gate->reset();
        $this->assertInstanceOf('Cqrs\Bus\SystemBus', $this->gate->getSystemBus());
        $this->gate->disableSystemBus();
        $this->assertNull($this->gate->getSystemBus());
    }

    public function testEnableSystemBus()
    {
        $this->gate->enableSystemBus();
        $systemBus = $this->gate->getSystemBus();
        $this->assertInstanceOf('Cqrs\Bus\SystemBus', $systemBus);
    }

    public function testGetSystemBus()
    {
        $this->gate->enableSystemBus();
        $this->assertInstanceOf('Cqrs\Bus\SystemBus', $this->gate->getSystemBus());
    }

    public function testGetNonInitializedSystemBus()
    {
        $this->gate->disableSystemBus();
        $this->assertNull($this->gate->getSystemBus());
    }

    public function testAttachFakeSystemBus()
    {
        $this->setExpectedException('Cqrs\Gate\GateException');
        $this->gate->enableSystemBus();
        $mockFakeSystemBus = new MockFakeSystemBus(
            new ClassMapCommandHandlerLoader(),
            new ClassMapEventListenerLoader(),
            new ClassMapQueryHandlerLoader()
        );
        $this->gate->attach($mockFakeSystemBus);
    }

    public function testDisableSystemBus()
    {
        if (is_null($this->gate->getSystemBus())) {
            $this->gate->enableSystemBus();
        }
        $this->gate->disableSystemBus();
        $systemBus = $this->gate->getSystemBus();
        $this->assertNull($systemBus);
    }

    public function testDetach()
    {
        $this->setExpectedException('Cqrs\Bus\BusException');
        $mockBus = new MockBus(
            new ClassMapCommandHandlerLoader(),
            new ClassMapEventListenerLoader(),
            new ClassMapQueryHandlerLoader()
        );
        $this->gate->attach($mockBus);
        
        $this->gate->detach($mockBus);
        $this->gate->getBus('test-coverage-mock-bus');
    }

    public function testAttachedBuses()
    {
        $this->gate->reset();
        $this->assertEquals(0, count($this->gate->attachedBuses()));
        $mockBus = new MockBus(
            new ClassMapCommandHandlerLoader(),
            new ClassMapEventListenerLoader(),
            new ClassMapQueryHandlerLoader()
        );
        $this->gate->attach($mockBus);
        $this->assertEquals(1, count($this->gate->attachedBuses()));
    }

    public function testAttach()
    {
        $mockBus = new MockBus(
            new ClassMapCommandHandlerLoader(),
            new ClassMapEventListenerLoader(),
            new ClassMapQueryHandlerLoader()
        );
        $this->gate->attach($mockBus);
        $this->assertEquals(
            $this->gate->getBus('test-coverage-mock-bus'),
            $mockBus
        );
    }

    public function testAttachSameBusTwice()
    {
        $this->setExpectedException('Cqrs\Gate\GateException');
        $mockBus = new MockBus(
            new ClassMapCommandHandlerLoader(),
            new ClassMapEventListenerLoader(),
            new ClassMapQueryHandlerLoader()
        );
        $this->gate->attach($mockBus);
        $this->gate->attach($mockBus);
    }

    public function testGetBus()
    {        
        $mockBus = new MockBus(
            new ClassMapCommandHandlerLoader(),
            new ClassMapEventListenerLoader(),
            new ClassMapQueryHandlerLoader()
        );
        
        $this->gate->attach($mockBus);
        
        $this->assertEquals(
            $this->gate->getBus('test-coverage-mock-bus'),
            $mockBus
        );
    }
    
    public function testGetBus_oneBusIsDefault()
    {
        $mockBus = new MockBus(
            new ClassMapCommandHandlerLoader(),
            new ClassMapEventListenerLoader(),
            new ClassMapQueryHandlerLoader()
        );
        
        $this->gate->attach($mockBus);
        
        $this->assertEquals(
            $this->gate->getBus(),
            $mockBus
        );
    }
    
    public function testGetBus_DefaultBusSet()
    {
        $mockBus = new MockBus(
            new ClassMapCommandHandlerLoader(),
            new ClassMapEventListenerLoader(),
            new ClassMapQueryHandlerLoader()
        );
        
        $anotherBus = new \Test\Coverage\Mock\Bus\MockAnotherBus(
            new ClassMapCommandHandlerLoader(),
            new ClassMapEventListenerLoader(),
            new ClassMapQueryHandlerLoader()
        );
        
        $this->gate->attach($mockBus);
        $this->gate->attach($anotherBus);
        $this->gate->setDefaultBusName($mockBus->getName());
        
        $this->assertEquals(
            $this->gate->getBus(),
            $mockBus
        );
    }
    
    public function testGetBus_ErrorWhenNoDefaultBusIsDefined()
    {
        $this->setExpectedException('Cqrs\Bus\BusException');
        
        $mockBus = new MockBus(
            new ClassMapCommandHandlerLoader(),
            new ClassMapEventListenerLoader(),
            new ClassMapQueryHandlerLoader()
        );
        
        $anotherBus = new \Test\Coverage\Mock\Bus\MockAnotherBus(
            new ClassMapCommandHandlerLoader(),
            new ClassMapEventListenerLoader(),
            new ClassMapQueryHandlerLoader()
        );
        
        $this->gate->attach($mockBus);
        $this->gate->attach($anotherBus);
                
        $this->assertEquals(
            $this->gate->getBus(),
            $mockBus
        );
    }
}