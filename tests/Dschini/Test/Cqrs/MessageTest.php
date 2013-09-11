<?php
/**
 * Created by JetBrains PhpStorm.
 * User: manfredweber
 * Date: 11.09.13
 * Time: 19:58
 * To change this template use File | Settings | File Templates.
 */

namespace Dschini\Test\Cqrs;

use Dschini\Cqrs\Message;
use Dschini\Test\TestCase;

class MessageTest extends TestCase {

    public function testValidMessage()
    {
        $message = new Message("Test");
        $this->assertAttributeNotEmpty("id",$message);
        $this->assertAttributeNotEmpty("type",$message);
        $this->assertAttributeNotEmpty("ts",$message);
    }

}