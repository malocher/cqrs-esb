<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Malocher\Cqrs\Configuration;

use Malocher\Cqrs\Command\ClassMapCommandHandlerLoader;
use Malocher\Cqrs\Event\ClassMapEventListenerLoader;
use Malocher\Cqrs\Gate;
use Malocher\Cqrs\Query\ClassMapQueryHandlerLoader;
use Test\Integration\Test5\Test5Command;
use Test\Integration\Test5\Test5Event;
use Test\TestCase;

/**
 * Class Test5
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Malocher\Cqrs\Configuration
 */
class Test5 extends TestCase
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

    public function testInitialize()
    {
        $configuration = array(
            'adapters' => array(
                'Malocher\Cqrs\Adapter\AnnotationAdapter' => array(
                    'buses' => array(
                        'Test\Integration\Test5\Test5Bus' => array(
                            'Test\Integration\Test5\Test5Handler'
                        )
                    )
                ),
            ),
        );
        $this->object->initialize($configuration);
        $bus = $this->object->getGate()->getBus('test-integration-test5-bus');

        $mockCommand = new Test5Command();
        $mockCommand->callback = function ($isEdited) {
            $this->assertTrue($isEdited);
        };

        $mockEvent = new Test5Event();
        $mockEvent->callback = function ($isEdited) {
            $this->assertTrue($isEdited);
        };

        $bus->invokeCommand($mockCommand);
        $bus->publishEvent($mockEvent);
    }
}
