<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Malocher\CqrsTest\Coverage\Cqrs\Bus;

use Malocher\Cqrs\Adapter\AnnotationAdapter;
use Malocher\Cqrs\Bus\AbstractBus;
use Malocher\Cqrs\Command\ClassMapCommandHandlerLoader;
use Malocher\Cqrs\Command\CommandInterface;
use Malocher\Cqrs\Event\ClassMapEventListenerLoader;
use Malocher\Cqrs\Event\EventInterface;
use Malocher\Cqrs\Gate;
use Malocher\Cqrs\Query\ClassMapQueryHandlerLoader;
use Malocher\Cqrs\Query\QueryInterface;
use Malocher\CqrsTest\Coverage\Mock\Command\MockCommand;
use Malocher\CqrsTest\Coverage\Mock\Event\MockEvent;
use Malocher\CqrsTest\Coverage\Mock\Query\MockQuery;
use Malocher\CqrsTest\TestCase;

/**
 * Class AbstractBusTest
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Malocher\CqrsTest\Coverage\Cqrs\Bus
 */
class AbstractBusTest extends TestCase implements BusInterfaceTest
{
    /**
     * @var AbstractBus
     */
    public $bus;

    public function setUp()
    {
        $this->bus = $this->getMockForAbstractClass('Malocher\Cqrs\Bus\AbstractBus');
        
        $this->bus->setCommandHandlerLoader(new ClassMapCommandHandlerLoader());
        $this->bus->setEventListenerLoader(new ClassMapEventListenerLoader());
        $this->bus->setQueryHandlerLoader(new ClassMapQueryHandlerLoader());
    }

    public function testConstructed()
    {
        $this->assertInstanceOf('Malocher\Cqrs\Bus\AbstractBus', $this->bus);
    }

    public function testSetGate()
    {
        $this->bus->setGate(new Gate());
        $this->assertInstanceOf('Malocher\Cqrs\Gate', $this->bus->getGate());
    }

    public function testGetGate()
    {
        if (is_null($this->bus->getGate())) {
            $this->bus->setGate(new Gate());
        }
        $this->assertInstanceOf('Malocher\Cqrs\Gate', $this->bus->getGate());
    }

    public function testMapQuery()
    {
        $this->bus->mapQuery('Malocher\CqrsTest\Coverage\Mock\Query\MockQuery', function (QueryInterface $query) {
        });
        $this->assertNotNull($this->bus->getQueryHandlerMap()['Malocher\CqrsTest\Coverage\Mock\Query\MockQuery']);
    }

    public function testGetQueryHandlerMap()
    {
        $this->bus->mapQuery('Malocher\CqrsTest\Coverage\Mock\Query\MockQuery', function (QueryInterface $query) {
        });
        $this->assertEquals(1, count($this->bus->getQueryHandlerMap()));
    }

    public function testExecuteQuery()
    {
        $gate = new Gate();
        $gate->attach($this->bus);
        $this->bus->mapQuery('Malocher\CqrsTest\Coverage\Mock\Query\MockQuery', function (MockQuery $query) {
            $query->edit();
            return array(1, 2, 3, 4, 5);
        });
        $mockQuery = new MockQuery();        
        $result = $this->bus->executeQuery($mockQuery);
        $this->assertEquals($result, array(1, 2, 3, 4, 5));
        $this->assertEquals(true, $mockQuery->isEdited());
    }

    public function testExecuteQueryNoResult()
    {
        $gate = new Gate();
        $gate->attach($this->bus);
        $this->bus->mapQuery('Malocher\CqrsTest\Coverage\Mock\Query\MockQuery', function (MockQuery $query) {
            $query->edit();
            return null;
        });
        $mockQuery = new MockQuery();
        $result = $this->bus->executeQuery($mockQuery);
        $this->assertNull($result);
        $this->assertEquals(true, $mockQuery->isEdited());
    }

    public function testArrayExecuteQuery()
    {
        $gate = new Gate();
        $gate->attach($this->bus);
        $this->bus->mapQuery('Malocher\CqrsTest\Coverage\Mock\Query\MockQuery', array(
            'alias' => 'Malocher\CqrsTest\Coverage\Mock\Query\MockQueryHandler',
            'method' => 'handleQuery'
        ));
        $mockQuery = new MockQuery();
        $result = $this->bus->executeQuery($mockQuery);
        $this->assertEquals($result, array(1, 2, 3, 4, 5));
        $this->assertEquals(true, $mockQuery->isEdited());
    }

    public function testArrayExecuteQueryNoResult()
    {
        $gate = new Gate();
        $gate->attach($this->bus);
        $this->bus->mapQuery('Malocher\CqrsTest\Coverage\Mock\Query\MockQuery', array(
            'alias' => 'Malocher\CqrsTest\Coverage\Mock\Query\MockQueryHandler',
            'method' => 'handleQueryWithNoResult'
        ));
        $mockQuery = new MockQuery();
        $result = $this->bus->executeQuery($mockQuery);
        $this->assertNull($result);
        $this->assertEquals(true, $mockQuery->isEdited());
    }

    public function testExecuteQueryHandlerAnnotationAdapter()
    {
        $this->bus->setGate(new Gate());
        $adapter = new AnnotationAdapter();
        $adapter->pipe($this->bus, array('Malocher\CqrsTest\Coverage\Mock\Query\MockCallbackQueryHandler'));
        $mockQuery = new MockQuery();
        $mockQuery->callback = function ($isEdited) {
        };
        $result = $this->bus->executeQuery($mockQuery);
        $this->assertEquals($result, array(1, 2, 3, 4, 5));
        $this->assertEquals(true, $mockQuery->isEdited());
    }

    public function testExecuteQueryHandlerNoAdapter()
    {
        $this->setExpectedException('Malocher\Cqrs\Bus\BusException');
        $this->bus->setGate(new Gate());
        $adapter = new AnnotationAdapter();
        $adapter->pipe($this->bus, array('Malocher\CqrsTest\Coverage\Mock\Query\MockQueryHandlerNoAdapter'));
        $mockQuery = new MockQuery();
        $mockQuery->callback = function ($isEdited) {
        };
        $result = $this->bus->executeQuery($mockQuery);
        $this->assertEquals($result, array(1, 2, 3, 4, 5));
    }
    
    public function testExcecuteQueryHandlerNoQueryHandlerLoader()
    {
        $this->setExpectedException('Malocher\Cqrs\Bus\BusException');
        
        $bus = $this->getMockForAbstractClass('Malocher\Cqrs\Bus\AbstractBus'); 
        
        $bus->setGate(new Gate());
        $bus->mapQuery('Malocher\CqrsTest\Coverage\Mock\Query\MockQuery', array(
            'alias' => 'Malocher\CqrsTest\Coverage\Mock\Query\MockQueryHandler',
            'method' => 'handleQueryWithNoResult'
        ));
        $mockQuery = new MockQuery();
        $result = $bus->executeQuery($mockQuery);
    }

    public function testMapCommand()
    {
        $this->bus->mapCommand('Malocher\CqrsTest\Coverage\Mock\Command\MockCommand', function (CommandInterface $command) {
        });
        $this->assertNotNull($this->bus->getCommandHandlerMap()['Malocher\CqrsTest\Coverage\Mock\Command\MockCommand']);
    }

    public function testGetCommandHandlerMap()
    {
        $this->bus->mapCommand('Malocher\CqrsTest\Coverage\Mock\Command\MockCommand', function (CommandInterface $command) {
        });
        $this->assertEquals(1, count($this->bus->getCommandHandlerMap()));
    }

    public function testInvokeCommand()
    {
        $gate = new Gate();
        $gate->attach($this->bus);
        $this->bus->mapCommand('Malocher\CqrsTest\Coverage\Mock\Command\MockCommand', function (MockCommand $command) {
            $command->edit();
        });
        $mockCommand = new MockCommand();
        $this->bus->invokeCommand($mockCommand);
        $this->assertEquals(true, $mockCommand->isEdited());
    }

    public function testInvokeCommandHandlerAnnotationAdapter()
    {
        $this->bus->setGate(new Gate());
        $adapter = new AnnotationAdapter();
        $adapter->pipe($this->bus, array('Malocher\CqrsTest\Coverage\Mock\Command\MockCallbackCommandHandler'));
        $mockCommand = new MockCommand();
        $mockCommand->callback = function ($isEdited) {
        };
        $this->bus->invokeCommand($mockCommand);
        $this->assertEquals(true, $mockCommand->isEdited());
    }

    public function testInvokeCommandHandlerNoAdapter()
    {
        $this->setExpectedException('Malocher\Cqrs\Bus\BusException');
        $this->bus->setGate(new Gate());
        $adapter = new AnnotationAdapter();
        $adapter->pipe($this->bus, array('Malocher\CqrsTest\Coverage\Mock\Command\MockCommandHandlerNoAdapter'));
        $mockCommand = new MockCommand();
        $mockCommand->callback = function ($isEdited) {
        };
        $this->bus->invokeCommand($mockCommand);
    }
    
    public function testInvokeCommandHanlderNoCommandHandlerLoader()
    {        
        $this->setExpectedException('Malocher\Cqrs\Bus\BusException');
        
        $bus = $this->getMockForAbstractClass('Malocher\Cqrs\Bus\AbstractBus'); 
        
        $bus->setGate(new Gate());
        $bus->mapCommand('Malocher\CqrsTest\Coverage\Mock\Command\MockCommand', array(
            'alias' => 'Malocher\CqrsTest\Coverage\Mock\Command\MockCommandHandler',
            'method' => 'handleCommand'
        ));
        $mockCommand = new MockCommand();
        $bus->invokeCommand($mockCommand);    
    }

    public function testRegisterEventListener()
    {
        $this->bus->registerEventListener('Malocher\CqrsTest\Coverage\Mock\Event\MockEvent', function (EventInterface $event) {
        });
        $this->assertNotNull($this->bus->getEventListenerMap()['Malocher\CqrsTest\Coverage\Mock\Event\MockEvent']);
    }

    public function testGetEventListenerMap()
    {
        $this->bus->registerEventListener('Malocher\CqrsTest\Coverage\Mock\Event\MockEvent', function (EventInterface $event) {
        });
        $this->assertEquals(1, count($this->bus->getEventListenerMap()));
    }

    public function testPublishEvent()
    {
        $gate = new Gate();
        $gate->attach($this->bus);
        $this->bus->registerEventListener('Malocher\CqrsTest\Coverage\Mock\Event\MockEvent', function (MockEvent $event) {
            $event->edit();
        });
        $mockEvent = new MockEvent();
        $this->bus->publishEvent($mockEvent);
        $this->assertEquals(true, $mockEvent->isEdited());
    }

    public function testPublishEventHandlerAnnotationAdapter()
    {
        $this->bus->setGate(new Gate());
        $adapter = new AnnotationAdapter();
        $adapter->pipe($this->bus, array('Malocher\CqrsTest\Coverage\Mock\Event\MockCallbackEventHandler'));
        $mockEvent = new MockEvent();
        $mockEvent->callback = function ($isEdited) {
        };
        $this->bus->publishEvent($mockEvent);
        $this->assertEquals(true, $mockEvent->isEdited());
    }

    public function testPublishEventHandlerNoAdapter()
    {
        $this->setExpectedException('Malocher\Cqrs\Bus\BusException');
        $this->bus->setGate(new Gate());
        $adapter = new AnnotationAdapter();
        $adapter->pipe($this->bus, array('Malocher\CqrsTest\Coverage\Mock\Event\MockEventHandlerNoAdapter'));
        $mockEvent = new MockEvent();
        $mockEvent->callback = function ($isEdited) {
        };
        $this->bus->publishEvent($mockEvent);
        $this->assertEquals(true, $mockEvent->isEdited());
    }

    public function testInvokeNonMappedCommand()
    {
        $this->bus->setGate(new Gate());
        $mockCommand = new MockCommand();
        $this->assertFalse($this->bus->invokeCommand($mockCommand));
    }

    public function testInvokeNonMappedEvent()
    {
        $this->bus->setGate(new Gate());
        $mockEvent = new MockEvent();
        $this->assertFalse($this->bus->publishEvent($mockEvent));
    }
    
    public function testPublishEventHandlerNoEventHandlerLoader()
    {
        $this->setExpectedException('Malocher\Cqrs\Bus\BusException');
        
        $bus = $this->getMockForAbstractClass('Malocher\Cqrs\Bus\AbstractBus'); 
        
        $bus->setGate(new Gate());
        $bus->registerEventListener('Malocher\CqrsTest\Coverage\Mock\Event\MockEvent', array(
            'alias' => 'Malocher\CqrsTest\Coverage\Mock\Event\MockEventHandler',
            'method' => 'handleEvent'
        ));
        $mockEvent = new MockEvent();
        $bus->publishEvent($mockEvent);    
    }
}
