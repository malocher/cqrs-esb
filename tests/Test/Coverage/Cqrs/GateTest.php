<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Cqrs;

use Cqrs\Command\ClassMapCommandHandlerLoader;
use Cqrs\Event\ClassMapEventListenerLoader;
use Cqrs\Gate;
use Test\Coverage\Mock\Bus\MockBus;
use Test\Coverage\Mock\Bus\MockFakeSystemBus;
use Test\TestCase;

/**
 * Gate
 *
 * @author Manfred Weber <manfred.weber@gmail.com>
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class GateTest extends TestCase {

    private $gate;

    public function setUp()
    {
        $this->gate = new Gate();
    }

    public function testConstructed()
    {
        $this->assertInstanceOf('Cqrs\Gate',$this->gate);
    }

    public function testReset()
    {
        $mockBus = new MockBus(
            new ClassMapCommandHandlerLoader(),
            new ClassMapEventListenerLoader()
        );
        $this->gate->attach($mockBus);
        $this->gate->reset();
        $attachedBuses = $this->gate->attachedBuses();
        $this->assertEquals(0,count($attachedBuses));
    }

    public function testResetSystemBus()
    {
        $this->gate->enableSystemBus();
        $this->gate->reset();
        $attachedBuses = $this->gate->attachedBuses();
        $this->assertEquals(1,count($attachedBuses));
        $this->gate->disableSystemBus();
        $this->gate->reset();
        $attachedBuses = $this->gate->attachedBuses();
        $this->assertEquals(0,count($attachedBuses));
    }

    public function testEnableSystemBus()
    {
        $this->gate->enableSystemBus();
        $systemBus = $this->gate->getBus('system-bus');
        $this->assertInstanceOf('Cqrs\Bus\SystemBus',$systemBus);
    }

    public function testAttachFakeSystemBus()
    {
        $this->setExpectedException('Cqrs\Gate\GateException');
        $this->gate->enableSystemBus();
        $mockFakeSystemBus = new MockFakeSystemBus(
            new ClassMapCommandHandlerLoader(),
            new ClassMapEventListenerLoader()
        );
        $this->gate->attach($mockFakeSystemBus);
    }

    public function testDisableSystemBus()
    {
        if(is_null($this->gate->getBus('system-bus'))){
            $this->gate->enableSystemBus();
        }
        $this->gate->disableSystemBus();
        $systemBus = $this->gate->getBus('system-bus');
        $this->assertNull( $systemBus );
    }

    public function testDetach()
    {
        $mockBus = $this->gate->getBus('test-coverage-mock-bus');
        if(is_null($mockBus)){
            $mockBus = new MockBus(
                new ClassMapCommandHandlerLoader(),
                new ClassMapEventListenerLoader()
            );
            $this->gate->attach($mockBus);
        }
        $this->gate->detach($mockBus);
        $this->assertNull( $this->gate->getBus('test-coverage-mock-bus') );
    }

    public function testAttachedBuses()
    {
        $this->gate->reset();
        $this->assertEquals(0,count($this->gate->attachedBuses()));
        $mockBus = new MockBus(
            new ClassMapCommandHandlerLoader(),
            new ClassMapEventListenerLoader()
        );
        $this->gate->attach($mockBus);
        $this->assertEquals(1,count($this->gate->attachedBuses()));
    }

    public function testAttach()
    {
        $mockBus = new MockBus(
            new ClassMapCommandHandlerLoader(),
            new ClassMapEventListenerLoader()
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
            new ClassMapEventListenerLoader()
        );
        $this->gate->attach($mockBus);
        $this->gate->attach($mockBus);
    }

    public function testGetBus()
    {
        $mockBus = $this->gate->getBus('test-coverage-mock-bus');
        if(is_null($mockBus)){
            $mockBus = new MockBus(
                new ClassMapCommandHandlerLoader(),
                new ClassMapEventListenerLoader()
            );
            $this->gate->attach($mockBus);
        }
        $this->assertEquals(
            $this->gate->getBus('test-coverage-mock-bus'),
            $mockBus
        );
    }

}