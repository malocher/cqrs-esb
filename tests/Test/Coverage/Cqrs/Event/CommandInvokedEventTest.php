<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Test\Coverage\Cqrs\Event;

use Cqrs\Event\CommandInvokedEvent;
use Test\Coverage\Cqrs\MessageTest;

/**
 * Class CommandInvokedEventTest
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Test\Coverage\Cqrs\Event
 */
class CommandInvokedEventTest extends MessageTest implements EventInterfaceTest
{
    public function setUp()
    {
        $this->message = new CommandInvokedEvent();
    }

    public function testSetClass()
    {
        $class = get_class($this->message);
        $this->message->setClass($class);
        $this->assertEquals($class, $this->message->getClass());
    }

    public function testGetClass()
    {
        if (is_null($this->message->getClass())) {
            $this->message->setClass(get_class($this->message));
        }
        $this->assertEquals(get_class($this->message), $this->message->getClass());
    }

    public function testSetId()
    {
        $id = uniqid();
        $this->message->setId($id);
        $this->assertEquals($id, $this->message->getId());
    }

    public function testSetTimestamp()
    {
        $ts = date_timestamp_get(date_create());
        $this->message->setTimestamp($ts);
        $this->assertEquals($ts, $this->message->getTimestamp());
    }

    public function testSetArguments()
    {
        $args = array(1, 2, 3, 4, 5);
        $this->message->setArguments($args);
        $this->assertEquals($args, $this->message->getArguments());
    }
}