<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Malocher\Test\Integration;

use Malocher\Cqrs\Command\ClassMapCommandHandlerLoader;
use Malocher\Cqrs\Event\ClassMapEventListenerLoader;
use Malocher\Cqrs\Gate;
use Malocher\Cqrs\Query\ClassMapQueryHandlerLoader;
use Malocher\Test\Integration\Integration1\Integration1Bus;
use Malocher\Test\Integration\Integration1\Integration1Command;
use Malocher\Test\Integration\Integration1\Integration1Event;
use Malocher\Test\Integration\Integration1\Integration1Handler;
use Malocher\Test\TestCase;

/**
 * Class IntegrationTest1
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Malocher\Test\Integration
 */
class Integration1Test extends TestCase
{

    /**
     * @var Gate
     */
    private $gate;

    /**
     * @var Integration1Bus
     */
    private $bus;

    /**
     *
     */
    protected function setUp()
    {
        $this->gate = new Gate();
        $this->bus = new Integration1Bus();
        $this->bus->setCommandHandlerLoader(new ClassMapCommandHandlerLoader());
        $this->bus->setEventListenerLoader(new ClassMapEventListenerLoader());
        $this->bus->setQueryHandlerLoader(new ClassMapQueryHandlerLoader());
        $this->bus->mapCommand(
            'Malocher\Test\Integration\Integration1\Integration1Command',
            array(
                'alias' => 'Malocher\Test\Integration\Integration1\Integration1Handler',
                'method' => 'editCommand'
            )
        );
        $this->bus->registerEventListener(
            'Malocher\Test\Integration\Integration1\Integration1Event',
            array(
                'alias' => 'Malocher\Test\Integration\Integration1\Integration1Handler',
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
        $command = new Integration1Command();
        $command->callback = function (Integration1Handler $returnedHandler, Integration1Command $returnedCommand, $returnedCommandIsEdited) {
            $this->assertInstanceOf('Malocher\Test\Integration\Integration1\Integration1Handler', $returnedHandler);
            $this->assertInstanceOf('Malocher\Test\Integration\Integration1\Integration1Command', $returnedCommand);
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
        $event = new Integration1Event();
        $event->callback = function (Integration1Handler $returnedHandler, Integration1Event $returnedEvent, $returnedEventIsEdited) {
            $this->assertInstanceOf('Malocher\Test\Integration\Integration1\Integration1Handler', $returnedHandler);
            $this->assertInstanceOf('Malocher\Test\Integration\Integration1\Integration1Event', $returnedEvent);
            $this->assertTrue($returnedEventIsEdited);
            $this->assertTrue(true);
        };
        $this->bus->publishEvent($event);
    }
}
