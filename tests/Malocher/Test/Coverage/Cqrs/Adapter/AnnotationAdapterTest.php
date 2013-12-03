<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Malocher\Test\Coverage\Cqrs\Adapter;

use Malocher\Cqrs\Adapter\AnnotationAdapter;
use Malocher\Cqrs\Command\ClassMapCommandHandlerLoader;
use Malocher\Cqrs\Event\ClassMapEventListenerLoader;
use Malocher\Cqrs\Query\ClassMapQueryHandlerLoader;
use Malocher\Test\Coverage\Mock\Bus\MockBus;
use Malocher\Test\TestCase;

/**
 * Class AnnotationAdapterTest
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Malocher\Test\Coverage\Cqrs\Adapter
 */
class AnnotationAdapterTest extends TestCase implements AdapterInterfaceTest
{
    /**
     * @var AnnotationAdapter
     */
    private $adapter;

    /**
     * @var MockBus
     */
    private $bus;

    public function setUp()
    {
        $this->adapter = new AnnotationAdapter();
        $this->bus = new MockBus(
            new ClassMapCommandHandlerLoader(),
            new ClassMapEventListenerLoader(),
            new ClassMapQueryHandlerLoader()
        );
    }

    public function testPipeWrongCommandHandler()
    {
        $this->setExpectedException('Malocher\Cqrs\Adapter\AdapterException');
        $configuration = array('Malocher\Test\Coverage\Mock\Command\NonExistingMockCommandHandler');
        $this->adapter->pipe($this->bus, $configuration);
    }

    public function testPipeProperCommandHandler()
    {
        $configuration = array('Malocher\Test\Coverage\Mock\Command\MockCommandHandler');
        $this->adapter->pipe($this->bus, $configuration);
        $map = $this->bus->getCommandHandlerMap()['Malocher\Test\Coverage\Mock\Command\MockCommand'];
        $this->assertNotNull($map);
        $this->assertEquals('Malocher\Test\Coverage\Mock\Command\MockCommandHandler', $map[0]['alias']);
    }

    public function testPipeWrongAnnotationsCommandHandler()
    {
        $this->setExpectedException('Malocher\Cqrs\Adapter\AdapterException');
        $configuration = array('Malocher\Test\Coverage\Mock\Command\MockCommandHandlerWrongAnnotations');
        $this->adapter->pipe($this->bus, $configuration);
    }

    public function testPipeWrongEventHandler()
    {
        $this->setExpectedException('Malocher\Cqrs\Adapter\AdapterException');
        $configuration = array('Malocher\Test\Coverage\Mock\Event\NonExistingMockEventHandler');
        $this->adapter->pipe($this->bus, $configuration);
    }

    public function testPipeProperEventHandler()
    {
        $configuration = array('Malocher\Test\Coverage\Mock\Event\MockEventHandler');
        $this->adapter->pipe($this->bus, $configuration);
        $map = $this->bus->getEventListenerMap()['Malocher\Test\Coverage\Mock\Event\MockEvent'];
        $this->assertNotNull($map);
        $this->assertEquals('Malocher\Test\Coverage\Mock\Event\MockEventHandler', $map[0]['alias']);
    }

    public function testPipeWrongAnnotationsEventHandler()
    {
        $this->setExpectedException('Malocher\Cqrs\Adapter\AdapterException');
        $configuration = array('Malocher\Test\Coverage\Mock\Event\MockEventHandlerWrongAnnotations');
        $this->adapter->pipe($this->bus, $configuration);
    }

}