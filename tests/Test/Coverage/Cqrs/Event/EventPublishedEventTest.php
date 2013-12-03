<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Test\Coverage\Cqrs\Event;

use Malocher\Cqrs\Event\EventPublishedEvent;
use Test\Coverage\Cqrs\Message\MessageTest;

/**
 * Class EventPublishedEventTest
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Test\Coverage\Cqrs\Event
 */
class EventPublishedEventTest extends MessageTest implements EventInterfaceTest
{
    public function setUp()
    {
        $this->message = new EventPublishedEvent();
    }

    public function testSetMessageClass()
    {
        $class = get_class($this->message);
        $this->message->setMessageClass($class);
        $this->assertEquals($class, $this->message->getMessageClass());
    }

    public function testGetMessageClass()
    {
        if (is_null($this->message->getMessageClass())) {
            $this->message->setMessageClass(get_class($this->message));
        }
        $this->assertEquals(get_class($this->message), $this->message->getMessageClass());
    }

    public function testSetMessageVars()
    {
        $vars = array(1, 2, 3, 4, 5);
        $this->message->setMessageVars($vars);
        $this->assertEquals($vars, $this->message->getMessageVars());
    }

    public function testGetMessageVars()
    {
        $vars = array(1, 2, 3, 4, 5);
        $this->message->setMessageVars($vars);
        $this->assertEquals($vars, $this->message->getMessageVars());
    }

    public function testSetBusName()
    {
        $this->message->setBusName('mock-bus-name');
        $this->assertEquals('mock-bus-name', $this->message->getBusName());
    }

    public function testGetBusName()
    {
        $this->message->setBusName('mock-bus-name');
        $this->assertEquals('mock-bus-name', $this->message->getBusName());
    }
}