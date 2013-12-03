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
use Malocher\Cqrs\Event\ClassMapEventListenerLoader;
use Malocher\Cqrs\Gate;
use Malocher\Cqrs\Configuration\Setup;
use Malocher\Cqrs\Query\ClassMapQueryHandlerLoader;
use Malocher\Test\Integration\Integration5\Integration5Command;
use Malocher\Test\Integration\Integration5\Integration5Event;
use Malocher\Test\TestCase;


/**
 * Class Integration5
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Malocher\Cqrs\Configuration
 */
class Integration5Test extends TestCase
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
                        'Malocher\Test\Integration\Integration5\Integration5Bus' => array(
                            'Malocher\Test\Integration\Integration5\Integration5Handler'
                        )
                    )
                ),
            ),
        );
        $this->object->initialize($configuration);
        $bus = $this->object->getGate()->getBus('test-integration-Integration5-bus');

        $mockCommand = new Integration5Command();
        $mockCommand->callback = function ($isEdited) {
            $this->assertTrue($isEdited);
        };

        $mockEvent = new Integration5Event();
        $mockEvent->callback = function ($isEdited) {
            $this->assertTrue($isEdited);
        };

        $bus->invokeCommand($mockCommand);
        $bus->publishEvent($mockEvent);
    }
}
