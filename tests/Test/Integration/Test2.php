<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Integration;

use Cqrs\Adapter\AnnotationAdapter;

use Cqrs\Command\ClassMapCommandHandlerLoader;
use Cqrs\Event\ClassMapEventListenerLoader;
use Cqrs\Gate;
use Test\Integration\Test2\Test2Bus;
use Test\Integration\Test2\Test2Command;
use Test\Integration\Test2\Test2Event;
use Test\Integration\Test2\Test2Handler;
use Test\TestCase;

/**
 * Class Test2
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Test\Integration
 */
class Test2 extends TestCase
{
    /**
     * @var Gate
     */
    private $gate;

    /**
     * @var Test2Bus
     */
    private $bus;

    /**
     * @var AnnotationAdapter
     */
    private $adapter;

    /**
     *
     */
    protected function setUp()
    {
        $this->gate = new Gate();
        $this->bus = new Test2Bus(
            new ClassMapCommandHandlerLoader(),
            new ClassMapEventListenerLoader()
        );
        $this->gate->attach($this->bus);
        $this->adapter = new AnnotationAdapter();
    }

    /**
     *
     */
    public function test1()
    {
        $this->adapter->pipe($this->bus, array('Test\Integration\Test2\Test2Handler'));
        $command = new Test2Command();
        $command->callback = function (Test2Handler $returnedHandler, Test2Command $returnedCommand, $returnedCommandIsEdited) {
            $this->assertInstanceOf('Test\Integration\Test2\Test2Handler', $returnedHandler);
            $this->assertInstanceOf('Test\Integration\Test2\Test2Command', $returnedCommand);
            $this->assertTrue($returnedCommandIsEdited);
            $this->assertTrue(true);
        };
        $this->bus->invokeCommand($command);
    }

    /**
     *
     */
    public function test2()
    {
        $this->adapter->pipe($this->bus, array('Test\Integration\Test2\Test2Handler'));
        $event = new Test2Event();
        $event->callback = function (Test2Handler $returnedHandler, Test2Event $returnedEvent, $returnedEventIsEdited) {
            $this->assertInstanceOf('Test\Integration\Test2\Test2Handler', $returnedHandler);
            $this->assertInstanceOf('Test\Integration\Test2\Test2Event', $returnedEvent);
            $this->assertTrue($returnedEventIsEdited);
            $this->assertTrue(true);
        };
        $this->bus->publishEvent($event);
    }

    /**
     *
     */
    public function test3()
    {
        $this->adapter->pipe($this->bus, array('Test\Integration\Test2\Test2Handler'));
        $command = new Test2Command();
        $command->callback = function (Test2Handler $returnedHandler, Test2Command $returnedCommand, $returnedCommandIsEdited) {
            $this->assertInstanceOf('Test\Integration\Test2\Test2Handler', $returnedHandler);
            $this->assertInstanceOf('Test\Integration\Test2\Test2Command', $returnedCommand);
            $this->assertTrue($returnedCommandIsEdited);
            $this->assertTrue(true);
        };
        $this->bus->invokeCommand($command);
    }

    /**
     *
     */
    public function test4()
    {
        $this->adapter->pipe($this->bus, array('Test\Integration\Test2\Test2Handler'));
        $event = new Test2Event();
        $event->callback = function (Test2Handler $returnedHandler, Test2Event $returnedEvent, $returnedEventIsEdited) {
            $this->assertInstanceOf('Test\Integration\Test2\Test2Handler', $returnedHandler);
            $this->assertInstanceOf('Test\Integration\Test2\Test2Event', $returnedEvent);
            $this->assertTrue($returnedEventIsEdited);
            $this->assertTrue(true);
        };
        $this->bus->publishEvent($event);
    }
}