<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Malocher\Test\Integration;

use Malocher\Cqrs\Command\ClassMapCommandHandlerLoader;
use Malocher\Cqrs\Gate;
use Malocher\Cqrs\Gate\GateException;
use Malocher\Cqrs\Query\ClassMapQueryHandlerLoader;
use Malocher\Test\Integration\Integration3\Integration3Bus;
use Malocher\Test\Integration\Integration3\Integration3Command;
use Malocher\Test\Integration\Integration3\Integration3Event;
use Malocher\Test\Integration\Integration3\Integration3EventListener;
use Malocher\Test\Integration\Integration3\Integration3EventListenerLoader;
use Malocher\Test\Integration\Integration3\Integration3InvokableEventListener;
use Malocher\Test\TestCase;


/**
 * Class Integration3
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Malocher\Cqrs\Bus
 */
class Integration3Test extends TestCase
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
     * @var Integration3EventListenerLoader
     */
    protected $Integration3EventListenerLoader;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $classMapCommandHandlerLoader = new ClassMapCommandHandlerLoader();
        $classMapQueryHandlerLoader = new ClassMapQueryHandlerLoader();
        $this->Integration3EventListenerLoader = new Integration3EventListenerLoader();
        $this->Integration3EventListenerLoader->setIntegration3EventListener(new Integration3EventListener());


        $this->bus = new Integration3Bus();
        $this->bus->setCommandHandlerLoader($classMapCommandHandlerLoader);
        $this->bus->setEventListenerLoader($this->Integration3EventListenerLoader);
        $this->bus->setQueryHandlerLoader($classMapQueryHandlerLoader);
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
            'Malocher\Test\Integration\Integration3\Integration3Command',
            array(
                'alias' => 'Malocher\Test\Integration\Integration3\Integration3CommandHandler',
                'method' => 'handleCommand'
            )
        );
        $Integration3Command = new Integration3Command();
        $this->gate->getBus('test-integration-Integration3-bus')->invokeCommand($Integration3Command);
        $this->assertTrue($Integration3Command->isEdited());
    }

    public function testInvokeCommand__withCallableCommandHandler()
    {
        $this->bus->mapCommand(
            'Malocher\Test\Integration\Integration3\Integration3Command',
            function (Integration3Command $command) {
                $command->edit();
            }
        );
        $Integration3Command = new Integration3Command();
        $this->gate->getBus('test-integration-Integration3-bus')->invokeCommand($Integration3Command);
        $this->assertTrue($Integration3Command->isEdited());
    }

    public function testPublishEvent__withEventListenerDefinition()
    {
        $this->bus->registerEventListener(
            'Malocher\Test\Integration\Integration3\Integration3Event',
            array(
                'alias' => 'Integration3_event_listener',
                'method' => 'onIntegration3'
            )
        );
        $Integration3Event = new Integration3Event(array('message' => 'it works'));
        $this->bus->publishEvent($Integration3Event);
        $this->assertEquals(
            'it works',
            $this->Integration3EventListenerLoader->getEventListener('Integration3_event_listener')->getIntegration3EventMessage()
        );
    }

    public function testPublishEvent__withInvokableEventListener()
    {
        $Integration3InvokableEventListener = new Integration3InvokableEventListener();
        $this->bus->registerEventListener('Malocher\Test\Integration\Integration3\Integration3Event', $Integration3InvokableEventListener);
        $Integration3Event = new Integration3Event(array('message' => 'it works'));
        $this->bus->publishEvent($Integration3Event);
        $this->assertEquals(
            'it works',
            $Integration3InvokableEventListener->getIntegration3EventMessage()
        );
    }
}
