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

    public function testInitialize()
    {
        $monitor = new \Test\Coverage\Mock\Command\MockCommandMonitor();
        
        $configuration = array(
            'adapters' => array(
                array(
                    'class' => 'Cqrs\Adapter\ArrayMapAdapter',
                    'buses' => array(
                        'Test\Coverage\Mock\Bus\MockBus' => array(
                            'Test\Coverage\Mock\Command\MockCommand' => array(
                                'alias' => 'Test\Coverage\Mock\Command\MockCommandHandler',
                                'method' => 'handleCommand'
                            )
                        ),
                        'Cqrs\Bus\SystemBus' => array(
                            'Cqrs\Command\InvokeCommandCommand' => $monitor,
                            'Cqrs\Event\CommandInvokedEvent'    => $monitor,
                        )
                    )
                ),
            ),
        );
        $this->setup->setGate(new Gate());
        $this->setup->setCommandHandlerLoader(new ClassMapCommandHandlerLoader());
        $this->setup->setEventListenerLoader(new ClassMapEventListenerLoader());
        $this->setup->initialize($configuration);

        $this->assertInstanceOf('Cqrs\Gate', $this->setup->getGate());
        $this->assertInstanceOf('Cqrs\Command\CommandHandlerLoaderInterface', $this->setup->getCommandHandlerLoader());
        $this->assertInstanceOf('Cqrs\Event\EventListenerLoaderInterface', $this->setup->getEventListenerLoader());
        $this->assertInstanceOf('Test\Coverage\Mock\Bus\MockBus', $this->setup->getGate()->getBus('test-coverage-mock-bus'));

        $this->assertInstanceOf('Cqrs\Bus\SystemBus', $this->setup->getGate()->getSystemBus());
        
        $mockCommand = new \Test\Coverage\Mock\Command\MockCommand();
        
        $this->setup->getGate()->getBus('test-coverage-mock-bus')->invokeCommand($mockCommand);
        
        $this->assertTrue($mockCommand->isEdited());
        
        $invokeCommandCommand = $monitor->getInvokeCommandCommands()[0];
        $commandInvokedEvent  = $monitor->getCommandInvokedEvents()[0];
        
        $this->assertEquals('Test\Coverage\Mock\Command\MockCommand', $invokeCommandCommand->getMessageClass());
        $this->assertEquals('Test\Coverage\Mock\Command\MockCommand', $commandInvokedEvent->getMessageClass());
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
                array(
                    'class' => 'Cqrs\Adapter\ArrayMapAdapter',
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
                array(
                    'class' => 'Cqrs\Adapter\ArrayMapAdapter',
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

    /*
    protected function testLoadAdapter(array $configuration)
    {
    }

    protected function testLoadBus($busClass)
    {
    }
    */
}
