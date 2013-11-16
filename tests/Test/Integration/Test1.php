<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Integration;

use Cqrs\Command\ClassMapCommandHandlerLoader;
use Cqrs\Event\ClassMapEventListenerLoader;
use Cqrs\Gate;
use Cqrs\Query\ClassMapQueryHandlerLoader;
use Test\Integration\Test1\Test1Bus;
use Test\Integration\Test1\Test1Command;
use Test\Integration\Test1\Test1Event;
use Test\Integration\Test1\Test1Handler;
use Test\TestCase;

/**
 * Class Test1
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Test\Integration
 */
class Test1 extends TestCase
{

    /**
     * @var Gate
     */
    private $gate;

    /**
     * @var Test1Bus
     */
    private $bus;

    /**
     *
     */
    protected function setUp()
    {
        $this->gate = new Gate();
        $this->bus = new Test1Bus();
        $this->bus->setCommandHandlerLoader(new ClassMapCommandHandlerLoader());
        $this->bus->setEventListenerLoader(new ClassMapEventListenerLoader());
        $this->bus->setQueryHandlerLoader(new ClassMapQueryHandlerLoader());
        $this->bus->mapCommand(
            'Test\Integration\Test1\Test1Command',
            array(
                'alias' => 'Test\Integration\Test1\Test1Handler',
                'method' => 'editCommand'
            )
        );
        $this->bus->registerEventListener(
            'Test\Integration\Test1\Test1Event',
            array(
                'alias' => 'Test\Integration\Test1\Test1Handler',
                'method' => 'editEvent'
            )
        );
        $this->gate->attach($this->bus);
    }

    /**
     *
     */
    public function test1()
    {
        $command = new Test1Command();
        $command->callback = function (Test1Handler $returnedHandler, Test1Command $returnedCommand, $returnedCommandIsEdited) {
            $this->assertInstanceOf('Test\Integration\Test1\Test1Handler', $returnedHandler);
            $this->assertInstanceOf('Test\Integration\Test1\Test1Command', $returnedCommand);
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
        $event = new Test1Event();
        $event->callback = function (Test1Handler $returnedHandler, Test1Event $returnedEvent, $returnedEventIsEdited) {
            $this->assertInstanceOf('Test\Integration\Test1\Test1Handler', $returnedHandler);
            $this->assertInstanceOf('Test\Integration\Test1\Test1Event', $returnedEvent);
            $this->assertTrue($returnedEventIsEdited);
            $this->assertTrue(true);
        };
        $this->bus->publishEvent($event);
    }
}