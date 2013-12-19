<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Malocher\CqrsTest\Coverage\Cqrs\Adapter;

use Malocher\Cqrs\Adapter\ArrayMapAdapter;
use Malocher\Cqrs\Command\ClassMapCommandHandlerLoader;
use Malocher\Cqrs\Event\ClassMapEventListenerLoader;
use Malocher\Cqrs\Query\ClassMapQueryHandlerLoader;
use Malocher\CqrsTest\Coverage\Mock\Bus\MockBus;
use Malocher\CqrsTest\TestCase;

/**
 * Class ArrayMapAdapterTest
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Malocher\CqrsTest\Coverage\Cqrs\Adapter
 */
class ArrayMapAdapterTest extends TestCase implements AdapterInterfaceTest
{
    /**
     * @var ArrayMapAdapter
     */
    private $adapter;

    /**
     * @var MockBus
     */
    private $bus;

    public function setUp()
    {
        $this->adapter = new ArrayMapAdapter();
        $this->bus = new MockBus(
            new ClassMapCommandHandlerLoader(),
            new ClassMapEventListenerLoader(),
            new ClassMapQueryHandlerLoader()
        );
    }

    public function testPipeWrongQuery()
    {
        $this->setExpectedException('Malocher\Cqrs\Adapter\AdapterException');
        $configuration = array(
            'Malocher\CqrsTest\Coverage\Mock\Query\NonExistentMockQuery' => array(
                'alias' => 'Malocher\CqrsTest\Coverage\Mock\Query\MockQueryHandler',
                'method' => 'handleQuery'
            )
        );
        $this->adapter->pipe($this->bus, $configuration);
    }

    public function testPipeProperQuery()
    {
        $configuration = array(
            'Malocher\CqrsTest\Coverage\Mock\Query\MockQuery' => array(
                'alias' => 'Malocher\CqrsTest\Coverage\Mock\Query\MockQueryHandler',
                'method' => 'handleQuery'
            )
        );
        $this->adapter->pipe($this->bus, $configuration);
        $map = $this->bus->getQueryHandlerMap()['Malocher\CqrsTest\Coverage\Mock\Query\MockQuery'];
        $this->assertNotNull($map);
        $this->assertEquals($configuration['Malocher\CqrsTest\Coverage\Mock\Query\MockQuery']['alias'], $map[0]['alias']);
    }

    public function testPipeMockWrongQuery()
    {
        $this->setExpectedException('Malocher\Cqrs\Adapter\AdapterException');
        $configuration = array(
            'Malocher\CqrsTest\Coverage\Mock\Query\MockWrongQuery' => array(
                'alias' => 'Malocher\CqrsTest\Coverage\Mock\Query\MockQueryHandler',
                'method' => 'handleQuery'
            )
        );
        $this->adapter->pipe($this->bus, $configuration);
    }

    public function testPipeWrongCommand()
    {
        $this->setExpectedException('Malocher\Cqrs\Adapter\AdapterException');
        $configuration = array(
            'Malocher\CqrsTest\Coverage\Mock\Command\NonExistentMockCommand' => array(
                'alias' => 'Malocher\CqrsTest\Coverage\Mock\Command\MockCommandHandler',
                'method' => 'handleCommand'
            )
        );
        $this->adapter->pipe($this->bus, $configuration);
    }

    public function testPipeProperCommand()
    {
        $configuration = array(
            'Malocher\CqrsTest\Coverage\Mock\Command\MockCommand' => array(
                'alias' => 'Malocher\CqrsTest\Coverage\Mock\Command\MockCommandHandler',
                'method' => 'handleCommand'
            )
        );
        $this->adapter->pipe($this->bus, $configuration);
        $map = $this->bus->getCommandHandlerMap()['Malocher\CqrsTest\Coverage\Mock\Command\MockCommand'];
        $this->assertNotNull($map);
        $this->assertEquals($configuration['Malocher\CqrsTest\Coverage\Mock\Command\MockCommand']['alias'], $map[0]['alias']);
    }

    public function testPipeMockWrongCommand()
    {
        $this->setExpectedException('Malocher\Cqrs\Adapter\AdapterException');
        $configuration = array(
            'Malocher\CqrsTest\Coverage\Mock\Command\MockWrongCommand' => array(
                'alias' => 'Malocher\CqrsTest\Coverage\Mock\Command\MockCommandHandler',
                'method' => 'handleCommand'
            )
        );
        $this->adapter->pipe($this->bus, $configuration);
    }

    public function testPipeWrongEvent()
    {
        $this->setExpectedException('Malocher\Cqrs\Adapter\AdapterException');
        $configuration = array(
            'Malocher\CqrsTest\Coverage\Mock\Event\NonExistentMockEvent' => array(
                'alias' => 'Malocher\CqrsTest\Coverage\Mock\Event\MockEventHandler',
                'method' => 'handleEvent'
            )
        );
        $this->adapter->pipe($this->bus, $configuration);
    }

    public function testPipeProperEvent()
    {
        $configuration = array(
            'Malocher\CqrsTest\Coverage\Mock\Event\MockEvent' => array(
                'alias' => 'Malocher\CqrsTest\Coverage\Mock\Event\MockEventHandler',
                'method' => 'handleEvent'
            )
        );
        $this->adapter->pipe($this->bus, $configuration);
        $map = $this->bus->getEventListenerMap()['Malocher\CqrsTest\Coverage\Mock\Event\MockEvent'];
        $this->assertNotNull($map);
        $this->assertEquals($configuration['Malocher\CqrsTest\Coverage\Mock\Event\MockEvent']['alias'], $map[0]['alias']);
    }

    public function testPipeMockWrongEvent()
    {
        $this->setExpectedException('Malocher\Cqrs\Adapter\AdapterException');
        $configuration = array(
            'Malocher\CqrsTest\Coverage\Mock\Event\MockWrongEvent' => array(
                'alias' => 'Malocher\CqrsTest\Coverage\Mock\Event\MockEventHandler',
                'method' => 'handleEvent'
            )
        );
        $this->adapter->pipe($this->bus, $configuration);
    }
}
