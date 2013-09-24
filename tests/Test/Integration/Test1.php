<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Integration;

use Test\TestCase;
use Test\Integration\Test1\Test1Bus;
use Test\Integration\Test1\Test1Command;
use Test\Integration\Test1\Test1Event;
use Test\Integration\Test1\Test1Handler;

use Cqrs\Gate;
use Cqrs\Event\ClassMapEventListenerLoader;
use Cqrs\Command\ClassMapCommandHandlerLoader;

class Test1 extends TestCase {

    private $gate;
    private $bus;

    protected function setUp()
    {
        $this->gate = Gate::getInstance()->reset();
        $this->bus = new Test1Bus(
            new ClassMapCommandHandlerLoader(),
            new ClassMapEventListenerLoader()
        );
        $this->bus->mapCommand(
            'Test\Integration\Test1\Test1Command',
            array(
                'alias' => 'Test\Integration\Test1\Test1Handler',
                'method' => 'editCommand'
            )
        );
        $this->bus->registerEventListener(
            'Test\Integration\Test1\Test1Event',
            array(
                'alias' => 'Test\Integration\Test1\Test1Handler',
                'method' => 'editEvent'
            )
        );
        $this->gate->attach($this->bus);
    }

    public function test1(){
        $command = new Test1Command();
        $command->callback = function(Test1Handler $returnedHandler,Test1Command $returnedCommand, $returnedCommandIsEdited){
            $this->assertInstanceOf('Test\Integration\Test1\Test1Handler',$returnedHandler);
            $this->assertInstanceOf('Test\Integration\Test1\Test1Command',$returnedCommand);
            $this->assertTrue($returnedCommandIsEdited);
            $this->assertTrue(true);
        };
        $this->bus->invokeCommand($command);
    }

    public function test2(){
        $event = new Test1Event();
        $event->callback = function(Test1Handler $returnedHandler,Test1Event $returnedEvent, $returnedEventIsEdited){
            $this->assertInstanceOf('Test\Integration\Test1\Test1Handler',$returnedHandler);
            $this->assertInstanceOf('Test\Integration\Test1\Test1Event',$returnedEvent);
            $this->assertTrue($returnedEventIsEdited);
            $this->assertTrue(true);
        };
        $this->bus->publishEvent($event);
    }
}