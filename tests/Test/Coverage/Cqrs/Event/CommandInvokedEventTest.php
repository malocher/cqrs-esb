<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Test\Coverage\Cqrs\Event;

use Test\Coverage\Cqrs\MessageTest;

class CommandInvokedEventTest extends MessageTest implements EventInterfaceTest
{
    protected $class;

    /*public function testSetClass($class) {
    }*/

    public function testGetClass() {
        $this->assertTrue(true);
    }

    /*public function testSetId($id)
    {
    }

    public function testSetTimestamp($ts)
    {
    }

    public function testSetArguments($args)
    {
    }*/
}