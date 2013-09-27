<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Cqrs\Bus;

use Cqrs\Bus\AbstractBus;
use Cqrs\Command\ClassMapCommandHandlerLoader;
use Cqrs\Command\CommandInterface;
use Cqrs\Event\ClassMapEventListenerLoader;
use Cqrs\Gate;
use Test\Coverage\Mock\Command\MockCommand;
use Test\Coverage\Mock\Event\MockEvent;
use Test\TestCase;

abstract class AbstractBusTest extends TestCase implements BusInterfaceTest
{
    /**
     * @var AbstractBus
     */
    private $bus;

    public function setUp()
    {
        $this->bus = $this->getMockForAbstractClass('Cqrs\Bus\AbstractBus',array(
            new ClassMapCommandHandlerLoader(), new ClassMapEventListenerLoader()
        ));
    }

    public function testConstructed()
    {
        $this->assertInstanceOf('Cqrs\Bus\AbstractBus',$this->bus);
    }
    
    public function testSetGate() {
        $this->bus->setGate(new Gate());
    }

    public function testMapCommand()
    {
        $this->bus->mapCommand('Test\Coverage\Mock\Command\MockCommand',function(CommandInterface $command){});
        $this->assertNotNull($this->bus->getCommandHandlerMap()['Test\Coverage\Mock\Command\MockCommand']);
    }

    public function testGetCommandHandlerMap()
    {
        $this->bus->mapCommand('Test\Coverage\Mock\Command\MockCommand',function(CommandInterface $command){});
        $this->assertEquals(1,count($this->bus->getCommandHandlerMap()));
    }
    
    public function testInvokeCommand()
    {
        $gate = new Gate();
        $gate->attach($this->bus);
        $this->bus->mapCommand('Test\Coverage\Mock\Command\MockCommand',function(MockCommand $command){
            $command->edit();
        });
        $mockCommand = new MockCommand();
        $this->bus->invokeCommand($mockCommand);
        $this->assertEquals(true,$mockCommand->isEdited());
    }
    
    public function testRegisterEventListener()
    {
        $this->bus->registerEventListener('Test\Coverage\Mock\Event\MockEvent',function(EventInterface $event){});
        $this->assertNotNull($this->bus->getEventListenerMap()['Test\Coverage\Mock\Event\MockEvent']);
    }

    public function testGetEventListenerMap()
    {
        $this->bus->registerEventListener('Test\Coverage\Mock\Event\MockEvent',function(EventInterface $event){});
        $this->assertEquals(1,count($this->bus->getEventListenerMap()));
    }
    
    public function testPublishEvent()
    {
        $gate = new Gate();
        $gate->attach($this->bus);
        $this->bus->registerEventListener('Test\Coverage\Mock\Event\MockEvent',function(MockEvent $event){
            $event->edit();
        });
        $mockEvent = new MockEvent();
        $this->bus->publishEvent($mockEvent);
        $this->assertEquals(true,$mockEvent->isEdited());
    }
}
