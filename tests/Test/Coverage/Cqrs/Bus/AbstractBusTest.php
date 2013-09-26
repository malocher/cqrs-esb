<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Cqrs\Bus;

use Test\Coverage\Cqrs\Command\CommandHandlerLoaderInterfaceTest;
use Test\Coverage\Cqrs\Command\CommandInterfaceTest;
use Test\Coverage\Cqrs\Event\EventInterfaceTest;
use Test\Coverage\Cqrs\Event\EventListenerLoaderInterfaceTest;
use Test\Coverage\Cqrs\GateTest;
use Test\TestCase;

abstract class AbstractBusTest extends TestCase implements BusInterfaceTest
{
    protected $commandHandlerLoader;
    
    protected $eventListenerLoader;
    
    protected $commandHandlerMap = array();

    protected $eventListenerMap  = array();

    protected $gate;
    
    /*public function __construct(
        CommandHandlerLoaderInterfaceTest $commandHandlerLoader,
        EventListenerLoaderInterfaceTest $eventListenerLoader) {
        
        $this->commandHandlerLoader = $commandHandlerLoader;
        $this->eventListenerLoader  = $eventListenerLoader;
    }*/
    
    /*public function testSetGate(GateTest $gate) {
    }*/
    
    /*public function testMapCommand($commandClass, $callableOrDefinition)
    {
    }*/
    
    /*public function testInvokeCommand(CommandInterfaceTest $command)
    {
    }*/
    
    /*public function testRegisterEventListener($eventClass, $callableOrDefinition)
    {
    }*/
    
    /*public function testPublishEvent(EventInterfaceTest $event)
    {
    }*/
}
