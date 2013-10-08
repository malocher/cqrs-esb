<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Cqrs\Adapter;

use Cqrs\Adapter\ArrayMapAdapter;
use Cqrs\Command\ClassMapCommandHandlerLoader;
use Cqrs\Event\ClassMapEventListenerLoader;
use Cqrs\Query\ClassMapQueryHandlerLoader;
use Test\Coverage\Mock\Bus\MockBus;
use Test\TestCase;

/**
 * Class ArrayMapAdapterTest
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Test\Coverage\Cqrs\Adapter
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
        $this->setExpectedException('Cqrs\Adapter\AdapterException');
        $configuration = array(
            'Test\Coverage\Mock\Query\NonExistentMockQuery' => array(
                'alias' => 'Test\Coverage\Mock\Query\MockQueryHandler',
                'method' => 'handleQuery'
            )
        );
        $this->adapter->pipe($this->bus, $configuration);
    }

    public function testPipeProperQuery()
    {
        $configuration = array(
            'Test\Coverage\Mock\Query\MockQuery' => array(
                'alias' => 'Test\Coverage\Mock\Query\MockQueryHandler',
                'method' => 'handleQuery'
            )
        );
        $this->adapter->pipe($this->bus, $configuration);
        $map = $this->bus->getQueryHandlerMap()['Test\Coverage\Mock\Query\MockQuery'];
        $this->assertNotNull($map);
        $this->assertEquals($configuration['Test\Coverage\Mock\Query\MockQuery']['alias'], $map[0]['alias']);
    }

    public function testPipeMockWrongQuery()
    {
        $this->setExpectedException('Cqrs\Adapter\AdapterException');
        $configuration = array(
            'Test\Coverage\Mock\Query\MockWrongQuery' => array(
                'alias' => 'Test\Coverage\Mock\Query\MockQueryHandler',
                'method' => 'handleQuery'
            )
        );
        $this->adapter->pipe($this->bus, $configuration);
    }

    public function testPipeWrongCommand()
    {
        $this->setExpectedException('Cqrs\Adapter\AdapterException');
        $configuration = array(
            'Test\Coverage\Mock\Command\NonExistentMockCommand' => array(
                'alias' => 'Test\Coverage\Mock\Command\MockCommandHandler',
                'method' => 'handleCommand'
            )
        );
        $this->adapter->pipe($this->bus, $configuration);
    }

    public function testPipeProperCommand()
    {
        $configuration = array(
            'Test\Coverage\Mock\Command\MockCommand' => array(
                'alias' => 'Test\Coverage\Mock\Command\MockCommandHandler',
                'method' => 'handleCommand'
            )
        );
        $this->adapter->pipe($this->bus, $configuration);
        $map = $this->bus->getCommandHandlerMap()['Test\Coverage\Mock\Command\MockCommand'];
        $this->assertNotNull($map);
        $this->assertEquals($configuration['Test\Coverage\Mock\Command\MockCommand']['alias'], $map[0]['alias']);
    }

    public function testPipeMockWrongCommand()
    {
        $this->setExpectedException('Cqrs\Adapter\AdapterException');
        $configuration = array(
            'Test\Coverage\Mock\Command\MockWrongCommand' => array(
                'alias' => 'Test\Coverage\Mock\Command\MockCommandHandler',
                'method' => 'handleCommand'
            )
        );
        $this->adapter->pipe($this->bus, $configuration);
    }

    public function testPipeWrongEvent()
    {
        $this->setExpectedException('Cqrs\Adapter\AdapterException');
        $configuration = array(
            'Test\Coverage\Mock\Event\NonExistentMockEvent' => array(
                'alias' => 'Test\Coverage\Mock\Event\MockEventHandler',
                'method' => 'handleEvent'
            )
        );
        $this->adapter->pipe($this->bus, $configuration);
    }

    public function testPipeProperEvent()
    {
        $configuration = array(
            'Test\Coverage\Mock\Event\MockEvent' => array(
                'alias' => 'Test\Coverage\Mock\Event\MockEventHandler',
                'method' => 'handleEvent'
            )
        );
        $this->adapter->pipe($this->bus, $configuration);
        $map = $this->bus->getEventListenerMap()['Test\Coverage\Mock\Event\MockEvent'];
        $this->assertNotNull($map);
        $this->assertEquals($configuration['Test\Coverage\Mock\Event\MockEvent']['alias'], $map[0]['alias']);
    }

    public function testPipeMockWrongEvent()
    {
        $this->setExpectedException('Cqrs\Adapter\AdapterException');
        $configuration = array(
            'Test\Coverage\Mock\Event\MockWrongEvent' => array(
                'alias' => 'Test\Coverage\Mock\Event\MockEventHandler',
                'method' => 'handleEvent'
            )
        );
        $this->adapter->pipe($this->bus, $configuration);
    }
}
