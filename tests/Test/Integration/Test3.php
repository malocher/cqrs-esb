<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cqrs\Bus;

use Cqrs\Command\ClassMapCommandHandlerLoader;
use Cqrs\Gate;
use Cqrs\Gate\GateException;
use Test\Integration\Test3\Test3Bus;
use Test\Integration\Test3\Test3Command;
use Test\Integration\Test3\Test3Event;
use Test\Integration\Test3\Test3EventListener;
use Test\Integration\Test3\Test3EventListenerLoader;
use Test\Integration\Test3\Test3InvokableEventListener;
use Test\TestCase;


/**
 * Class Test3
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Cqrs\Bus
 */
class Test3 extends TestCase
{

    /**
     * @var Gate
     */
    protected $gate;

    /**
     * @var AbstractBus
     */
    protected $bus;

    /**
     *
     * @var Test3EventListenerLoader
     */
    protected $test3EventListenerLoader;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $classMapCommandHandlerLoader = new ClassMapCommandHandlerLoader();
        $this->test3EventListenerLoader = new Test3EventListenerLoader();
        $this->test3EventListenerLoader->setTest3EventListener(new Test3EventListener());
        $this->bus = new Test3Bus($classMapCommandHandlerLoader, $this->test3EventListenerLoader);
        $this->gate = new Gate();
        try {
            $this->gate->attach($this->bus);
        } catch (GateException $e) {
            echo $e->getMessage();
        }
    }

    public function testInvokeCommand__withCommandHandlerDefinition()
    {
        $this->bus->mapCommand(
            'Test\Integration\Test3\Test3Command',
            array(
                'alias' => 'Test\Integration\Test3\Test3CommandHandler',
                'method' => 'handleCommand'
            )
        );
        $test3Command = new Test3Command();
        $this->gate->getBus('test-integration-test3-bus')->invokeCommand($test3Command);
        $this->assertTrue($test3Command->isEdited());
    }

    public function testInvokeCommand__withCallableCommandHandler()
    {
        $this->bus->mapCommand(
            'Test\Integration\Test3\Test3Command',
            function (Test3Command $command) {
                $command->edit();
            }
        );
        $test3Command = new Test3Command();
        $this->gate->getBus('test-integration-test3-bus')->invokeCommand($test3Command);
        $this->assertTrue($test3Command->isEdited());
    }

    public function testPublishEvent__withEventListenerDefinition()
    {
        $this->bus->registerEventListener(
            'Test\Integration\Test3\Test3Event',
            array(
                'alias' => 'test3_event_listener',
                'method' => 'onTest3'
            )
        );
        $test3Event = new Test3Event(array('message' => 'it works'));
        $this->bus->publishEvent($test3Event);
        $this->assertEquals(
            'it works',
            $this->test3EventListenerLoader->getEventListener('test3_event_listener')->getTest3EventMessage()
        );
    }

    public function testPublishEvent__withInvokableEventListener()
    {
        $test3InvokableEventListener = new Test3InvokableEventListener();
        $this->bus->registerEventListener('Test\Integration\Test3\Test3Event', $test3InvokableEventListener);
        $test3Event = new Test3Event(array('message' => 'it works'));
        $this->bus->publishEvent($test3Event);
        $this->assertEquals(
            'it works',
            $test3InvokableEventListener->getTest3EventMessage()
        );
    }
}
