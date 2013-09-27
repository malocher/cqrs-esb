<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Cqrs\Adapter;

use Cqrs\Adapter\AnnotationAdapter;
use Cqrs\Command\ClassMapCommandHandlerLoader;
use Cqrs\Event\ClassMapEventListenerLoader;
use Test\Coverage\Mock\Bus\MockBus;
use Test\TestCase;

class AnnotationAdapterTest extends TestCase implements AdapterInterfaceTest
{
   use AdapterTraitTest;

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
            new ClassMapEventListenerLoader()
        );
    }

    public function testPipeWrongCommand()
    {
        $this->setExpectedException('Cqrs\Adapter\AdapterException');
        $configuration = array('Test\Coverage\Mock\Command\NonExistingMockCommandHandler');
        $this->adapter->pipe( $this->bus, $configuration );
    }

    public function testPipeProperCommand()
    {
        $configuration = array('Test\Coverage\Mock\Command\MockCommandHandler');
        $this->adapter->pipe( $this->bus, $configuration );
        $map = $this->bus->getCommandHandlerMap()['Test\Coverage\Mock\Command\MockCommand'];
        $this->assertNotNull($map);
        $this->assertEquals('Test\Coverage\Mock\Command\MockCommandHandler',$map[0]['alias']);
    }

    public function testPipeWrongEvent()
    {
        $this->setExpectedException('Cqrs\Adapter\AdapterException');
        $configuration = array('Test\Coverage\Mock\Event\NonExistingMockEventHandler');
        $this->adapter->pipe( $this->bus, $configuration );
    }

    public function testPipeProperEvent()
    {
        $configuration = array('Test\Coverage\Mock\Event\MockEventHandler');
        $this->adapter->pipe( $this->bus, $configuration );
        $map = $this->bus->getEventListenerMap()['Test\Coverage\Mock\Event\MockEvent'];
        $this->assertNotNull($map);
        $this->assertEquals('Test\Coverage\Mock\Event\MockEventHandler',$map[0]['alias']);
    }

}