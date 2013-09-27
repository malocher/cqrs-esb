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