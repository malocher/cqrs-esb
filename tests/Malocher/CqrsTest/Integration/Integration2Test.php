<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Malocher\CqrsTest\Integration;

use Malocher\Cqrs\Adapter\AnnotationAdapter;
use Malocher\Cqrs\Command\ClassMapCommandHandlerLoader;
use Malocher\Cqrs\Event\ClassMapEventListenerLoader;
use Malocher\Cqrs\Gate;
use Malocher\Cqrs\Query\ClassMapQueryHandlerLoader;
use Malocher\CqrsTest\Integration\Integration2\Integration2Bus;
use Malocher\CqrsTest\Integration\Integration2\Integration2Command;
use Malocher\CqrsTest\Integration\Integration2\Integration2Event;
use Malocher\CqrsTest\Integration\Integration2\Integration2Handler;
use Malocher\CqrsTest\TestCase;

/**
 * Class Integration2
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Malocher\CqrsTest\Integration
 */
class Integration2Test extends TestCase
{
    /**
     * @var Gate
     */
    private $gate;

    /**
     * @var Integration2Bus
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
        $this->bus = new Integration2Bus();
        $this->bus->setCommandHandlerLoader(new ClassMapCommandHandlerLoader());
        $this->bus->setEventListenerLoader(new ClassMapEventListenerLoader());
        $this->bus->setQueryHandlerLoader(new ClassMapQueryHandlerLoader());
        $this->gate->attach($this->bus);
        $this->adapter = new AnnotationAdapter();
    }

    /**
     *
     */
    public function test1()
    {
        $this->adapter->pipe($this->bus, array('Malocher\CqrsTest\Integration\Integration2\Integration2Handler'));
        $command = new Integration2Command();
        $command->callback = function (Integration2Handler $returnedHandler, Integration2Command $returnedCommand, $returnedCommandIsEdited) {
            $this->assertInstanceOf('Malocher\CqrsTest\Integration\Integration2\Integration2Handler', $returnedHandler);
            $this->assertInstanceOf('Malocher\CqrsTest\Integration\Integration2\Integration2Command', $returnedCommand);
            $this->assertTrue($returnedCommandIsEdited);
            $this->assertTrue(true);
        };
        $this->bus->invokeCommand($command);
    }

    /**
     * Second Test
     */
    public function test2()
    {
        $this->adapter->pipe($this->bus, array('Malocher\CqrsTest\Integration\Integration2\Integration2Handler'));
        $event = new Integration2Event();
        $event->callback = function (Integration2Handler $returnedHandler, Integration2Event $returnedEvent, $returnedEventIsEdited) {
            $this->assertInstanceOf('Malocher\CqrsTest\Integration\Integration2\Integration2Handler', $returnedHandler);
            $this->assertInstanceOf('Malocher\CqrsTest\Integration\Integration2\Integration2Event', $returnedEvent);
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
        $this->adapter->pipe($this->bus, array('Malocher\CqrsTest\Integration\Integration2\Integration2Handler'));
        $command = new Integration2Command();
        $command->callback = function (Integration2Handler $returnedHandler, Integration2Command $returnedCommand, $returnedCommandIsEdited) {
            $this->assertInstanceOf('Malocher\CqrsTest\Integration\Integration2\Integration2Handler', $returnedHandler);
            $this->assertInstanceOf('Malocher\CqrsTest\Integration\Integration2\Integration2Command', $returnedCommand);
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
        $this->adapter->pipe($this->bus, array('Malocher\CqrsTest\Integration\Integration2\Integration2Handler'));
        $event = new Integration2Event();
        $event->callback = function (Integration2Handler $returnedHandler, Integration2Event $returnedEvent, $returnedEventIsEdited) {
            $this->assertInstanceOf('Malocher\CqrsTest\Integration\Integration2\Integration2Handler', $returnedHandler);
            $this->assertInstanceOf('Malocher\CqrsTest\Integration\Integration2\Integration2Event', $returnedEvent);
            $this->assertTrue($returnedEventIsEdited);
            $this->assertTrue(true);
        };
        $this->bus->publishEvent($event);
    }
}
