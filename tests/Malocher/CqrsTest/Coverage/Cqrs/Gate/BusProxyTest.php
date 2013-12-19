<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Malocher\CqrsTest\Coverage\Cqrs\Gate;

use Malocher\Cqrs\Adapter\AnnotationAdapter;
use Malocher\Cqrs\Command\ClassMapCommandHandlerLoader;
use Malocher\Cqrs\Command\CommandInterface;
use Malocher\Cqrs\Event\ClassMapEventListenerLoader;
use Malocher\Cqrs\Event\EventInterface;
use Malocher\Cqrs\Gate\BusProxy;
use Malocher\Cqrs\Gate;
use Malocher\Cqrs\Query\ClassMapQueryHandlerLoader;
use Malocher\Cqrs\Query\QueryInterface;
use Malocher\CqrsTest\Coverage\Cqrs\Bus\BusInterfaceTest;
use Malocher\CqrsTest\Coverage\Mock\Bus\MockBus;
use Malocher\CqrsTest\Coverage\Mock\Command\MockCommand;
use Malocher\CqrsTest\Coverage\Mock\Event\MockEvent;
use Malocher\CqrsTest\Coverage\Mock\Query\MockQuery;
use Malocher\CqrsTest\TestCase;

/**
 * Class to proxy all bus communication
 *
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 * @package Malocher\Cqrs\Gate
 */
class BusProxyTest extends TestCase implements BusInterfaceTest
{
    /**
     * @var BusProxy $busProxy
     */
    protected $busProxy;

    public function setUp()
    {
        $bus = new MockBus();
        $bus->setCommandHandlerLoader(new ClassMapCommandHandlerLoader());
        $bus->setEventListenerLoader(new ClassMapEventListenerLoader());
        $bus->setQueryHandlerLoader(new ClassMapQueryHandlerLoader());
        $this->busProxy = new BusProxy($bus);
    }

    public function testConstructed()
    {
        $this->assertInstanceOf('Malocher\Cqrs\Gate\BusProxy', $this->busProxy);
    }

    
    public function test__call() 
    {
        $this->assertEquals(
            'Called from BusProxyText with message call works',
            $this->busProxy->customFunction('BusProxyText', 'call works')
        );
    }
    

    public function testSetGate()
    {
        $gate = new Gate();
        $this->busProxy->setGate($gate);
        $this->assertEquals($gate,$this->busProxy->getGate());
    }

    public function testGetGate()
    {
        $gate = new Gate();
        $this->busProxy->setGate($gate);
        $this->assertEquals($gate,$this->busProxy->getGate());
    }


    public function testGetBus()
    {
        $this->assertInstanceOf('Malocher\CqrsTest\Coverage\Mock\Bus\MockBus', $this->busProxy->getBus());
    }

    public function testGetName()
    {
        $this->assertEquals('test-coverage-mock-bus',$this->busProxy->getName());
    }

    public function testMapQuery()
    {
        $this->busProxy->mapQuery('Malocher\CqrsTest\Coverage\Mock\Query\MockQuery', function (QueryInterface $query) {
        });
        $this->assertNotNull($this->busProxy->getQueryHandlerMap()['Malocher\CqrsTest\Coverage\Mock\Query\MockQuery']);
    }

    public function testGetQueryHandlerMap()
    {
        $this->busProxy->mapQuery('Malocher\CqrsTest\Coverage\Mock\Query\MockQuery', function (QueryInterface $query) {
        });
        $this->assertEquals(1, count($this->busProxy->getQueryHandlerMap()));
    }

    public function testExecuteQuery()
    {
        $gate = new Gate();
        $gate->attach($this->busProxy);
        $this->busProxy->mapQuery('Malocher\CqrsTest\Coverage\Mock\Query\MockQuery', function (MockQuery $query) {
            $query->edit();
            return array(1, 2, 3, 4, 5);
        });
        $mockQuery = new MockQuery();
        $result = $this->busProxy->executeQuery($mockQuery);
        $this->assertEquals($result, array(1, 2, 3, 4, 5));
        $this->assertEquals(true, $mockQuery->isEdited());
    }

    public function testExecuteQueryNoResult()
    {
        $gate = new Gate();
        $gate->attach($this->busProxy);
        $this->busProxy->mapQuery('Malocher\CqrsTest\Coverage\Mock\Query\MockQuery', function (MockQuery $query) {
            $query->edit();
            return null;
        });
        $mockQuery = new MockQuery();
        $result = $this->busProxy->executeQuery($mockQuery);
        $this->assertNull($result);
        $this->assertEquals(true, $mockQuery->isEdited());
    }

    public function testArrayExecuteQuery()
    {
        $gate = new Gate();
        $gate->attach($this->busProxy);
        $this->busProxy->mapQuery('Malocher\CqrsTest\Coverage\Mock\Query\MockQuery', array(
            'alias' => 'Malocher\CqrsTest\Coverage\Mock\Query\MockQueryHandler',
            'method' => 'handleQuery'
        ));
        $mockQuery = new MockQuery();
        $result = $this->busProxy->executeQuery($mockQuery);
        $this->assertEquals($result, array(1, 2, 3, 4, 5));
        $this->assertEquals(true, $mockQuery->isEdited());
    }

    public function testArrayExecuteQueryNoResult()
    {
        $gate = new Gate();
        $gate->attach($this->busProxy);
        $this->busProxy->mapQuery('Malocher\CqrsTest\Coverage\Mock\Query\MockQuery', array(
            'alias' => 'Malocher\CqrsTest\Coverage\Mock\Query\MockQueryHandler',
            'method' => 'handleQueryWithNoResult'
        ));
        $mockQuery = new MockQuery();
        $result = $this->busProxy->executeQuery($mockQuery);
        $this->assertNull($result);
        $this->assertEquals(true, $mockQuery->isEdited());
    }

    public function testExecuteQueryHandlerAnnotationAdapter()
    {
        $this->busProxy->setGate(new Gate());
        $adapter = new AnnotationAdapter();
        $adapter->pipe($this->busProxy, array('Malocher\CqrsTest\Coverage\Mock\Query\MockCallbackQueryHandler'));
        $mockQuery = new MockQuery();
        $mockQuery->callback = function ($isEdited) {
        };
        $result = $this->busProxy->executeQuery($mockQuery);
        $this->assertEquals($result, array(1, 2, 3, 4, 5));
        $this->assertEquals(true, $mockQuery->isEdited());
    }

    public function testExecuteQueryHandlerNoAdapter()
    {
        $this->setExpectedException('Malocher\Cqrs\Bus\BusException');
        $this->busProxy->setGate(new Gate());
        $adapter = new AnnotationAdapter();
        $adapter->pipe($this->busProxy, array('Malocher\CqrsTest\Coverage\Mock\Query\MockQueryHandlerNoAdapter'));
        $mockQuery = new MockQuery();
        $mockQuery->callback = function ($isEdited) {
        };
        $result = $this->busProxy->executeQuery($mockQuery);
        $this->assertEquals($result, array(1, 2, 3, 4, 5));
    }

    public function testExcecuteQueryHandlerNoQueryHandlerLoader()
    {
        $this->setExpectedException('Malocher\Cqrs\Bus\BusException');
        $bus = new MockBus();
        $bus->setGate(new Gate());
        $bus->mapQuery('Malocher\CqrsTest\Coverage\Mock\Query\MockQuery', array(
            'alias' => 'Malocher\CqrsTest\Coverage\Mock\Query\MockQueryHandler',
            'method' => 'handleQueryWithNoResult'
        ));
        $mockQuery = new MockQuery();
        $bus->executeQuery($mockQuery);
    }

    public function testMapCommand()
    {
        $this->busProxy->mapCommand('Malocher\CqrsTest\Coverage\Mock\Command\MockCommand', function (CommandInterface $command) {
        });
        $this->assertNotNull($this->busProxy->getCommandHandlerMap()['Malocher\CqrsTest\Coverage\Mock\Command\MockCommand']);
    }

    public function testGetCommandHandlerMap()
    {
        $this->busProxy->mapCommand('Malocher\CqrsTest\Coverage\Mock\Command\MockCommand', function (CommandInterface $command) {
        });
        $this->assertEquals(1, count($this->busProxy->getCommandHandlerMap()));
    }

    public function testInvokeCommand()
    {
        $gate = new Gate();
        $gate->attach($this->busProxy);
        $this->busProxy->mapCommand('Malocher\CqrsTest\Coverage\Mock\Command\MockCommand', function (MockCommand $command) {
            $command->edit();
        });
        $mockCommand = new MockCommand();
        $this->busProxy->invokeCommand($mockCommand);
        $this->assertEquals(true, $mockCommand->isEdited());
    }

    public function testInvokeCommandHandlerAnnotationAdapter()
    {
        $this->busProxy->setGate(new Gate());
        $adapter = new AnnotationAdapter();
        $adapter->pipe($this->busProxy, array('Malocher\CqrsTest\Coverage\Mock\Command\MockCallbackCommandHandler'));
        $mockCommand = new MockCommand();
        $mockCommand->callback = function ($isEdited) {
        };
        $this->busProxy->invokeCommand($mockCommand);
        $this->assertEquals(true, $mockCommand->isEdited());
    }

    public function testInvokeCommandHandlerNoAdapter()
    {
        $this->setExpectedException('Malocher\Cqrs\Bus\BusException');
        $this->busProxy->setGate(new Gate());
        $adapter = new AnnotationAdapter();
        $adapter->pipe($this->busProxy, array('Malocher\CqrsTest\Coverage\Mock\Command\MockCommandHandlerNoAdapter'));
        $mockCommand = new MockCommand();
        $mockCommand->callback = function ($isEdited) {
        };
        $this->busProxy->invokeCommand($mockCommand);
    }

    public function testInvokeCommandHanlderNoCommandHandlerLoader()
    {
        $this->setExpectedException('Malocher\Cqrs\Bus\BusException');
        $bus = new MockBus();
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
        $this->busProxy->registerEventListener('Malocher\CqrsTest\Coverage\Mock\Event\MockEvent', function (EventInterface $event) {
        });
        $this->assertNotNull($this->busProxy->getEventListenerMap()['Malocher\CqrsTest\Coverage\Mock\Event\MockEvent']);
    }

    public function testGetEventListenerMap()
    {
        $this->busProxy->registerEventListener('Malocher\CqrsTest\Coverage\Mock\Event\MockEvent', function (EventInterface $event) {
        });
        $this->assertEquals(1, count($this->busProxy->getEventListenerMap()));
    }

    public function testPublishEvent()
    {
        $gate = new Gate();
        $gate->attach($this->busProxy);
        $this->busProxy->registerEventListener('Malocher\CqrsTest\Coverage\Mock\Event\MockEvent', function (MockEvent $event) {
            $event->edit();
        });
        $mockEvent = new MockEvent();
        $this->busProxy->publishEvent($mockEvent);
        $this->assertEquals(true, $mockEvent->isEdited());
    }

    public function testPublishEventHandlerAnnotationAdapter()
    {
        $this->busProxy->setGate(new Gate());
        $adapter = new AnnotationAdapter();
        $adapter->pipe($this->busProxy, array('Malocher\CqrsTest\Coverage\Mock\Event\MockCallbackEventHandler'));
        $mockEvent = new MockEvent();
        $mockEvent->callback = function ($isEdited) {
        };
        $this->busProxy->publishEvent($mockEvent);
        $this->assertEquals(true, $mockEvent->isEdited());
    }

    public function testPublishEventHandlerNoAdapter()
    {
        $this->setExpectedException('Malocher\Cqrs\Bus\BusException');
        $this->busProxy->setGate(new Gate());
        $adapter = new AnnotationAdapter();
        $adapter->pipe($this->busProxy, array('Malocher\CqrsTest\Coverage\Mock\Event\MockEventHandlerNoAdapter'));
        $mockEvent = new MockEvent();
        $mockEvent->callback = function ($isEdited) {
        };
        $this->busProxy->publishEvent($mockEvent);
        $this->assertEquals(true, $mockEvent->isEdited());
    }

    public function testInvokeNonMappedCommand()
    {
        $this->busProxy->setGate(new Gate());
        $mockCommand = new MockCommand();
        $this->assertFalse($this->busProxy->invokeCommand($mockCommand));
    }

    public function testInvokeNonMappedEvent()
    {
        $this->busProxy->setGate(new Gate());
        $mockEvent = new MockEvent();
        $this->assertFalse($this->busProxy->publishEvent($mockEvent));
    }

    public function testPublishEventHandlerNoEventHandlerLoader()
    {
        $this->setExpectedException('Malocher\Cqrs\Bus\BusException');
        $bus = new MockBus();
        $bus->setGate(new Gate());
        $bus->registerEventListener('Malocher\CqrsTest\Coverage\Mock\Event\MockEvent', array(
            'alias' => 'Malocher\CqrsTest\Coverage\Mock\Event\MockEventHandler',
            'method' => 'handleEvent'
        ));
        $mockEvent = new MockEvent();
        $bus->publishEvent($mockEvent);
    }

}
