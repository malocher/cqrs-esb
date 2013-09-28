<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cqrs\Configuration;

use Cqrs\Command\ClassMapCommandHandlerLoader;
use Cqrs\Event\ClassMapEventListenerLoader;

use Cqrs\Gate;
use Test\Integration\Test4\Test4Command;
use Test\Integration\Test4\Test4Event;
use Test\TestCase;

/**
 * Class Test4
 *
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 * @package Cqrs\Configuration
 */
class Test4 extends TestCase
{
    /**
     * @var Setup
     */
    protected $object;

    protected function setUp()
    {
        $this->object = new Setup();
        $this->object->setGate(new Gate());
        $this->object->setCommandHandlerLoader(new ClassMapCommandHandlerLoader());
        $this->object->setEventListenerLoader(new ClassMapEventListenerLoader());
    }

    public function testInitializeCommand()
    {
        $configuration = array(
            'adapters' => array(
                array(
                    'class' => 'Cqrs\Adapter\ArrayMapAdapter',
                    'buses' => array(
                        'Test\Integration\Test4\Test4Bus' => array(
                            'Test\Integration\Test4\Test4Command' => array(
                                'alias' => 'Test\Integration\Test4\Test4CommandHandler',
                                'method' => 'handleCommand'
                            )
                        )
                    )
                ),
            ),
        );
        $this->object->initialize($configuration);
        $mockCommand = new Test4Command();
        $this->object->getGate()->getBus('test-integration-test4-bus')->invokeCommand($mockCommand);
        $this->assertTrue($mockCommand->isEdited());
    }

    public function testInitializeEvent()
    {
        $configuration = array(
            'adapters' => array(
                array(
                    'class' => 'Cqrs\Adapter\ArrayMapAdapter',
                    'buses' => array(
                        'Test\Integration\Test4\Test4Bus' => array(
                            'Test\Integration\Test4\Test4Event' => function (Test4Event $event) {
                                $event->edit();
                            }
                        )
                    )
                ),
            ),
        );
        $this->object->initialize($configuration);
        $mockEvent = new Test4Event();
        $this->object->getGate()->getBus('test-integration-test4-bus')->publishEvent($mockEvent);
        //The EventListenerCallback should call $mockEvent->edit(), otherwise
        //$mockEvent->isEdited() returns false
        $this->assertTrue($mockEvent->isEdited());
    }
}
