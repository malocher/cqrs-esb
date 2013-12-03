<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Malocher\Test\Coverage\Cqrs\Adapter;

use Malocher\Cqrs\Adapter\AdapterTrait;
use Malocher\Cqrs\Command\ClassMapCommandHandlerLoader;
use Malocher\Cqrs\Event\ClassMapEventListenerLoader;
use Malocher\Cqrs\Gate;
use Malocher\Cqrs\Query\ClassMapQueryHandlerLoader;
use Malocher\Test\Coverage\Mock\Bus\MockAnotherBus;
use Malocher\Test\Coverage\Mock\Bus\MockBus;
use Malocher\Test\Coverage\Mock\Command\MockCommand;
use Malocher\Test\Coverage\Mock\Event\MockEvent;
use Malocher\Test\Coverage\Mock\Query\MockQuery;
use Malocher\Test\TestCase;

/**
 * Class AdapterTraitTest
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Malocher\Test\Coverage\Cqrs\Adapter
 */
class AdapterTraitTest extends TestCase
{
    use AdapterTrait;

    /**
     * @var \Malocher\Cqrs\Bus\BusInterface
     */
    private $anotherBus;

    /**
     *
     */
    public function setUp()
    {
        $this->bus = new MockBus(
            new ClassMapCommandHandlerLoader(),
            new ClassMapEventListenerLoader(),
            new ClassMapQueryHandlerLoader()
        );
        $this->anotherBus = new MockAnotherBus(
            new ClassMapCommandHandlerLoader(),
            new ClassMapEventListenerLoader(),
            new ClassMapQueryHandlerLoader()
        );
        $gate = new Gate();
        $gate->attach($this->bus);
        $gate->attach($this->anotherBus);
    }

    /**
     * @param MockQuery $query
     * @return bool
     */
    public function executeQueryHandler(MockQuery $query)
    {
        $query->edit();
        return $query->isEdited();
    }

    /**
     *
     */
    public function testExecuteQuery()
    {
        $this->bus->mapQuery('Malocher\Test\Coverage\Mock\Query\MockQuery', array(
            'alias' => get_class($this),
            'method' => 'executeQueryHandler'
        ));
        $query = new MockQuery();
        $returnValue = $this->executeQuery($this->bus, $this, 'executeQueryHandler', $query);
        $this->assertTrue($query->isEdited());
        $this->assertTrue($returnValue);
    }

    /**
     * @param MockCommand $command
     */
    public function executeCommandHandler(MockCommand $command)
    {
        $command->edit();
    }

    /**
     *
     */
    public function testExecuteCommand()
    {
        $this->bus->mapCommand('Malocher\Test\Coverage\Mock\Command\MockCommand', array(
            'alias' => get_class($this),
            'method' => 'executeCommandHandler'
        ));
        $command = new MockCommand();
        $this->executeCommand($this->bus, $this, 'executeCommandHandler', $command);
        $this->assertTrue($command->isEdited());
    }

    /**
     * @param MockEvent $event
     */
    public function executeEventHandler(MockEvent $event)
    {
        $event->edit();
    }

    /**
     *
     */
    public function testExecuteEvent()
    {
        $this->bus->registerEventListener('Malocher\Test\Coverage\Mock\Event\MockEvent', array(
            'alias' => get_class($this),
            'method' => 'executeEventHandler'
        ));
        $event = new MockEvent();
        $this->executeEvent($this->bus, $this, 'executeEventHandler', $event);
        $this->assertTrue($event->isEdited());
    }

    /**
     *
     */
    public function testGetBus()
    {
        $bus = $this->getBus();
        $this->assertEquals($this->bus, $bus);
        $anotherBus = $this->getBus('test-coverage-mock-another-bus');
        $this->assertEquals($this->anotherBus->getName(), $anotherBus->getName());
    }
}