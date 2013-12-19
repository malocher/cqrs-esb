<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Malocher\CqrsTest\Integration;

use Malocher\Cqrs\Command\ClassMapCommandHandlerLoader;
use Malocher\Cqrs\Event\ClassMapEventListenerLoader;
use Malocher\Cqrs\Gate;
use Malocher\Cqrs\Configuration\Setup;
use Malocher\Cqrs\Query\ClassMapQueryHandlerLoader;
use Malocher\CqrsTest\Integration\Integration4\Integration4Command;
use Malocher\CqrsTest\Integration\Integration4\Integration4Event;
use Malocher\CqrsTest\TestCase;

/**
 * Class Integration4
 *
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 * @package Malocher\Cqrs\Configuration
 */
class Integration4Test extends TestCase
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
        $this->object->setQueryHandlerLoader(new ClassMapQueryHandlerLoader());
    }

    public function testInitializeCommand()
    {
        $configuration = [
            'adapters' => [
                'Malocher\Cqrs\Adapter\ArrayMapAdapter' => [
                    'buses' => [
                        'Malocher\CqrsTest\Integration\Integration4\Integration4Bus' => [
                            'Malocher\CqrsTest\Integration\Integration4\Integration4Command' => [
                                'alias' => 'Malocher\CqrsTest\Integration\Integration4\Integration4CommandHandler',
                                'method' => 'handleCommand'
                            ]
                        ]
                    ]
                ],
            ],
        ];
        $this->object->initialize($configuration);
        $mockCommand = new Integration4Command();
        $this->object->getGate()->getBus('test-integration-Integration4-bus')->invokeCommand($mockCommand);
        $this->assertTrue($mockCommand->isEdited());
    }

    public function testInitializeEvent()
    {
        $configuration = array(
            'adapters' => array(
                'Malocher\Cqrs\Adapter\ArrayMapAdapter' => array(
                    'buses' => array(
                        'Malocher\CqrsTest\Integration\Integration4\Integration4Bus' => array(
                            'Malocher\CqrsTest\Integration\Integration4\Integration4Event' => function (Integration4Event $event) {
                                $event->edit();
                            }
                        )
                    )
                ),
            ),
        );
        $this->object->initialize($configuration);
        $mockEvent = new Integration4Event();
        $this->object->getGate()->getBus('test-integration-Integration4-bus')->publishEvent($mockEvent);
        //The EventListenerCallback should call $mockEvent->edit(), otherwise
        //$mockEvent->isEdited() returns false
        $this->assertTrue($mockEvent->isEdited());
    }
}
