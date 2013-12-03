<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Cqrs\Configuration;

use Cqrs\Command\ClassMapCommandHandlerLoader;
use Cqrs\Configuration\Setup;
use Cqrs\Event\ClassMapEventListenerLoader;
use Cqrs\Gate;
use Cqrs\Query\ClassMapQueryHandlerLoader;
use Test\Coverage\Mock\Command\MockCommand;
use Test\Coverage\Mock\Command\MockCommandMonitor;
use Test\Coverage\Mock\Event\MockEvent;
use Test\TestCase;

/**
 * Class SetupTest
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Test\Coverage\Cqrs\Configuration
 */
class SetupTest extends TestCase
{
    /**
     * @var Setup
     */
    private $setup;

    public function setUp()
    {
        $this->setup = new Setup();
    }

    public function testConstructed()
    {
        $this->assertInstanceOf('Cqrs\Configuration\Setup', $this->setup);
    }

    public function testSetGate()
    {
        $gate = new Gate();
        $this->setup->setGate($gate);
        $this->assertEquals($gate, $this->setup->getGate());
        $this->assertInstanceOf('Cqrs\Gate', $this->setup->getGate());
    }

    public function testGetGate()
    {
        if (is_null($this->setup->getGate())) {
            $this->setup->setGate(new Gate());
        }
        $this->assertInstanceOf('Cqrs\Gate', $this->setup->getGate());
    }

    public function testSetCommandHandlerLoader()
    {
        $this->setup->setCommandHandlerLoader(new ClassMapCommandHandlerLoader());
        $this->assertInstanceOf('Cqrs\Command\ClassMapCommandHandlerLoader', $this->setup->getCommandHandlerLoader());
    }

    public function testGetCommandHandlerLoader()
    {
        if (is_null($this->setup->getCommandHandlerLoader())) {
            $this->setup->setCommandHandlerLoader(new ClassMapCommandHandlerLoader());
        }
        $this->assertInstanceOf('Cqrs\Command\ClassMapCommandHandlerLoader', $this->setup->getCommandHandlerLoader());
    }

    public function testSetEventListenerLoader()
    {
        $this->setup->setEventListenerLoader(new ClassMapEventListenerLoader());
        $this->assertInstanceOf('Cqrs\Event\ClassMapEventListenerLoader', $this->setup->getEventListenerLoader());
    }

    public function testGetEventListenerLoader()
    {
        if (is_null($this->setup->getEventListenerLoader())) {
            $this->setup->setEventListenerLoader(new ClassMapEventListenerLoader());
        }
        $this->assertInstanceOf('Cqrs\Event\ClassMapEventListenerLoader', $this->setup->getEventListenerLoader());
    }

    public function testSetGetQueryHandlerLoader()
    {
        $this->setup->setQueryHandlerLoader(new ClassMapQueryHandlerLoader());
        $this->assertInstanceOf('Cqrs\Query\QueryHandlerLoaderInterface', $this->setup->getQueryHandlerLoader());
    }

    public function testInitialize()
    {
        $monitor = new MockCommandMonitor();

        $configuration = array(
            'default_bus' => 'test-coverage-mock-bus',
            'adapters' => array(
                'Cqrs\Adapter\ArrayMapAdapter' => array(
                    'buses' => array(
                        'Test\Coverage\Mock\Bus\MockBus' => array(
                            'Test\Coverage\Mock\Command\MockCommand' => array(
                                'alias' => 'Test\Coverage\Mock\Command\MockCommandHandler',
                                'method' => 'handleCommand'
                            )
                        ),
                        'Test\Coverage\Mock\Bus\MockAnotherBus' => array(
                            'Test\Coverage\Mock\Event\MockEvent' => array(
                                'alias' => 'Test\Coverage\Mock\Event\MockEventHandler',
                                'method' => 'handleEvent'
                            )
                        ),
                        'Cqrs\Bus\SystemBus' => array(
                            'Cqrs\Command\InvokeCommandCommand' => $monitor,
                            'Cqrs\Event\CommandInvokedEvent' => $monitor,
                        )
                    )
                ),
            ),
        );
        $this->setup->setGate(new Gate());
        $this->setup->setCommandHandlerLoader(new ClassMapCommandHandlerLoader());
        $this->setup->setEventListenerLoader(new ClassMapEventListenerLoader());
        $this->setup->setQueryHandlerLoader(new ClassMapQueryHandlerLoader());
        $this->setup->initialize($configuration);

        $this->assertInstanceOf('Cqrs\Gate', $this->setup->getGate());
        $this->assertInstanceOf('Cqrs\Command\CommandHandlerLoaderInterface', $this->setup->getCommandHandlerLoader());
        $this->assertInstanceOf('Cqrs\Event\EventListenerLoaderInterface', $this->setup->getEventListenerLoader());
        $this->assertInstanceOf('Cqrs\Bus\BusInterface', $this->setup->getGate()->getBus('test-coverage-mock-bus'));

        $this->assertInstanceOf('Cqrs\Bus\SystemBus', $this->setup->getGate()->getSystemBus());

        $mockCommand = new MockCommand();

        $this->setup->getGate()->getBus('test-coverage-mock-bus')->invokeCommand($mockCommand);

        $this->assertTrue($mockCommand->isEdited());

        $invokeCommandCommand = $monitor->getInvokeCommandCommands()[0];
        $commandInvokedEvent = $monitor->getCommandInvokedEvents()[0];

        $this->assertEquals('Test\Coverage\Mock\Command\MockCommand', $invokeCommandCommand->getMessageClass());
        $this->assertEquals('Test\Coverage\Mock\Command\MockCommand', $commandInvokedEvent->getMessageClass());
        
        //test setup multiple buses
        $mockEvent = new MockEvent();
        
        $this->setup->getGate()->getBus('test-coverage-mock-another-bus')->publishEvent($mockEvent);
        $this->assertTrue($mockEvent->isEdited());
        
        //Test setup the default bus corectly
        $this->assertInstanceOf('Cqrs\Bus\BusInterface', $this->setup->getGate()->getBus());
    }

    public function testInitializeWithoutGate()
    {
        $this->setExpectedException('Cqrs\Configuration\ConfigurationException');
        $this->setup->initialize(array());
    }

    public function testInitializeWithoutCommandHandlerLoader()
    {
        $this->setExpectedException('Cqrs\Configuration\ConfigurationException');
        $configuration = array(
            'enable_system_bus' => true,
            'adapters' => array(
                'Cqrs\Adapter\ArrayMapAdapter' => array(
                    'buses' => array(
                        'Test\Coverage\Mock\Bus\MockBus' => array(
                            'Test\Coverage\Mock\Command\MockCommand' => array(
                                'alias' => 'Test\Coverage\Mock\Command\MockCommandHandler',
                                'method' => 'handleCommand'
                            )
                        )
                    )
                ),
            ),
        );
        $this->setup->setGate(new Gate());
        $this->setup->setEventListenerLoader(new ClassMapEventListenerLoader());
        $this->setup->initialize($configuration);
    }

    public function testInitializeWithoutEventHandlerLoader()
    {
        $this->setExpectedException('Cqrs\Configuration\ConfigurationException');
        $configuration = array(
            'enable_system_bus' => true,
            'adapters' => array(
                'Cqrs\Adapter\ArrayMapAdapter' => array(
                    'buses' => array(
                        'Test\Coverage\Mock\Bus\MockBus' => array(
                            'Test\Coverage\Mock\Command\MockCommand' => array(
                                'alias' => 'Test\Coverage\Mock\Command\MockCommandHandler',
                                'method' => 'handleCommand'
                            )
                        )
                    )
                ),
            ),
        );
        $this->setup->setGate(new Gate());
        $this->setup->setCommandHandlerLoader(new ClassMapCommandHandlerLoader());
        $this->setup->initialize($configuration);
    }
    
    public function testInitializeWithoutQuerytHandlerLoader()
    {
        $this->setExpectedException('Cqrs\Configuration\ConfigurationException');
        $configuration = array(
            'enable_system_bus' => true,
            'adapters' => array(
                'Cqrs\Adapter\ArrayMapAdapter' => array(
                    'buses' => array(
                        'Test\Coverage\Mock\Bus\MockBus' => array(
                            'Test\Coverage\Mock\Query\MockQuery' => array(
                                'alias' => 'Test\Coverage\Mock\Query\MockQueryHandler',
                                'method' => 'handleQuery'
                            )
                        )
                    )
                ),
            ),
        );
        $this->setup->setGate(new Gate());
        $this->setup->setCommandHandlerLoader(new ClassMapCommandHandlerLoader());
        $this->setup->setEventListenerLoader(new ClassMapEventListenerLoader());
        $this->setup->initialize($configuration);
    }
}
