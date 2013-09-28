<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Cqrs\Bus;

use Cqrs\Bus\AbstractBus;
use Cqrs\Command\InvokeCommandCommand;
use Cqrs\Command\PublishEventCommand;
use Cqrs\Event\CommandInvokedEvent;
use Cqrs\Event\EventPublishedEvent;
use Cqrs\Gate;
use Test\Coverage\Mock\Command\MockCommand;
use Test\Coverage\Mock\Event\MockEvent;

/**
 * Class SystemBusTest
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Test\Coverage\Cqrs\Bus
 */
class SystemBusTest extends AbstractBusTest
{
    /**
     * @var InvokeCommandCommand
     */
    private $invokeCommandCommand;

    /**
     * @var CommandInvokedEvent
     */
    private $commandInvokedEvent;

    /**
     * @var PublishEventCommand
     */
    private $publishEventCommand;

    /**
     * @var EventPublishedEvent
     */
    private $eventPublishedEvent;

    public function testGetName()
    {
        if (is_null($this->bus->getGate())) {
            $this->bus->setGate(new Gate());
        }
        $this->bus->getGate()->enableSystemBus();
        $this->assertEquals(AbstractBus::SYSTEMBUS, $this->bus->getGate()->getSystemBus()->getName());
    }

    public function testClosureInvokeCommand()
    {
        $gate = new Gate();
        $gate->enableSystemBus();
        $gate->attach($this->bus);
        $this->bus->mapCommand('Test\Coverage\Mock\Command\MockCommand', function (MockCommand $command) {
            $command->edit();
        });
        $gate->getSystemBus()->mapCommand('Cqrs\Command\InvokeCommandCommand', function (InvokeCommandCommand $command) {
            $this->invokeCommandCommand = $command;
        });
        $gate->getSystemBus()->registerEventListener('Cqrs\Event\CommandInvokedEvent', function (CommandInvokedEvent $event) {
            $this->commandInvokedEvent = $event;
        });
        $mockCommand = new MockCommand();
        $this->bus->invokeCommand($mockCommand);
        $this->assertEquals(true, $mockCommand->isEdited());
        $this->assertInstanceOf('Cqrs\Command\InvokeCommandCommand', $this->invokeCommandCommand);
        $this->assertInstanceOf('Cqrs\Event\CommandInvokedEvent', $this->commandInvokedEvent);
        $this->assertEquals('Test\Coverage\Mock\Command\MockCommand', $this->invokeCommandCommand->getClass());
        $this->assertEquals('Test\Coverage\Mock\Command\MockCommand', $this->commandInvokedEvent->getClass());
    }

    public function testClosurePublishEvent()
    {
        $gate = new Gate();
        $gate->enableSystemBus();
        $gate->attach($this->bus);
        $this->bus->registerEventListener('Test\Coverage\Mock\Event\MockEvent', function (MockEvent $event) {
            $event->edit();
        });
        $gate->getSystemBus()->mapCommand('Cqrs\Command\PublishEventCommand', function (PublishEventCommand $command) {
            $this->publishEventCommand = $command;
        });
        $gate->getSystemBus()->registerEventListener('Cqrs\Event\EventPublishedEvent', function (EventPublishedEvent $event) {
            $this->eventPublishedEvent = $event;
        });
        $mockEvent = new MockEvent();
        $this->bus->publishEvent($mockEvent);
        $this->assertEquals(true, $mockEvent->isEdited());
        $this->assertInstanceOf('Cqrs\Command\PublishEventCommand', $this->publishEventCommand);
        $this->assertInstanceOf('Cqrs\Event\EventPublishedEvent', $this->eventPublishedEvent);
        $this->assertEquals('Test\Coverage\Mock\Event\MockEvent', $this->publishEventCommand->getClass());
        $this->assertEquals('Test\Coverage\Mock\Event\MockEvent', $this->eventPublishedEvent->getClass());
    }

    public function testArrayMapInvokeCommand()
    {
        $gate = new Gate();
        $gate->enableSystemBus();
        $gate->attach($this->bus);
        $this->bus->mapCommand(
            'Test\Coverage\Mock\Command\MockCommand',
            array('alias' => 'Test\Coverage\Mock\Command\MockCommandHandler', 'method' => 'handleCommand')
        );
        $gate->getSystemBus()->mapCommand(
            'Cqrs\Command\InvokeCommandCommand',
            array('alias' => 'Test\Coverage\Mock\Command\MockCommandHandler', 'method' => 'handleCommand')
        );
        $gate->getSystemBus()->registerEventListener(
            'Cqrs\Event\CommandInvokedEvent',
            array('alias' => 'Test\Coverage\Mock\Event\MockEventHandler', 'method' => 'handleEvent')
        );
        $mockCommand = new MockCommand();
        $this->bus->invokeCommand($mockCommand);
        $this->assertEquals(true, $mockCommand->isEdited());
    }

    public function testArrayMapPublishEvent()
    {
        $gate = new Gate();
        $gate->enableSystemBus();
        $gate->attach($this->bus);
        $this->bus->registerEventListener(
            'Test\Coverage\Mock\Event\MockEvent',
            array('alias' => 'Test\Coverage\Mock\Event\MockEventHandler', 'method' => 'handleEvent')
        );
        $gate->getSystemBus()->mapCommand(
            'Cqrs\Command\PublishEventCommand',
            array('alias' => 'Test\Coverage\Mock\Command\MockCommandHandler', 'method' => 'handleCommand')
        );
        $gate->getSystemBus()->registerEventListener(
            'Cqrs\Event\EventPublishedEvent',
            array('alias' => 'Test\Coverage\Mock\Event\MockEventHandler', 'method' => 'handleEvent')
        );
        $mockEvent = new MockEvent();
        $this->bus->publishEvent($mockEvent);
        $this->assertEquals(true, $mockEvent->isEdited());
    }

    public function testArrayMapInvokeCommandMissingAdapterTrait()
    {
        $this->setExpectedException('Cqrs\Bus\BusException');
        $gate = new Gate();
        $gate->enableSystemBus();
        $gate->attach($this->bus);
        $this->bus->mapCommand(
            'Test\Coverage\Mock\Command\MockCommand',
            array('alias' => 'Test\Coverage\Mock\Command\MockCommandHandler', 'method' => 'handleCommand')
        );
        $gate->getSystemBus()->mapCommand(
            'Cqrs\Command\InvokeCommandCommand',
            array('alias' => 'Test\Coverage\Mock\Command\MockCommandHandlerNoAdapter', 'method' => 'handleCommand')
        );
        $gate->getSystemBus()->registerEventListener(
            'Cqrs\Event\CommandInvokedEvent',
            array('alias' => 'Test\Coverage\Mock\Event\MockEventHandler', 'method' => 'handleEvent')
        );
        $mockCommand = new MockCommand();
        $this->bus->invokeCommand($mockCommand);
    }

    public function testArrayMapPublishEventMissingAdapterTrait()
    {
        $this->setExpectedException('Cqrs\Bus\BusException');
        $gate = new Gate();
        $gate->enableSystemBus();
        $gate->attach($this->bus);
        $this->bus->registerEventListener(
            'Test\Coverage\Mock\Event\MockEvent',
            array('alias' => 'Test\Coverage\Mock\Event\MockEventHandler', 'method' => 'handleEvent')
        );
        $gate->getSystemBus()->mapCommand(
            'Cqrs\Command\PublishEventCommand',
            array('alias' => 'Test\Coverage\Mock\Command\MockCommandHandler', 'method' => 'handleCommand')
        );
        $gate->getSystemBus()->registerEventListener(
            'Cqrs\Event\EventPublishedEvent',
            array('alias' => 'Test\Coverage\Mock\Event\MockEventHandlerNoAdapter', 'method' => 'handleEvent')
        );
        $mockEvent = new MockEvent();
        $this->bus->publishEvent($mockEvent);
    }

    public function testInvokeNonMappedCommand()
    {
        $gate = new Gate();
        $gate->enableSystemBus();
        $mockCommand = new MockCommand();
        $this->assertFalse($gate->getSystemBus()->invokeCommand($mockCommand));
    }

    public function testInvokeNonMappedEvent()
    {
        $gate = new Gate();
        $gate->enableSystemBus();
        $mockEvent = new MockEvent();
        $this->assertFalse($gate->getSystemBus()->publishEvent($mockEvent));
    }

}