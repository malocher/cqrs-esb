<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Cqrs;

use Cqrs\Message;
use Test\TestCase;

/**
 * MessageTest
 *
 * @author Manfred Weber <manfred.weber@gmail.com>
 */
class MessageTest extends TestCase {

    protected $message;

    public function setUp()
    {
        $this->message = new Message();
    }

    public function testConstructed()
    {
        $this->assertInstanceOf('Cqrs\Message',$this->message);
    }

    public function testGetId()
    {
        $this->assertNotNull($this->message->getId());
    }

    public function testGetTimestamp()
    {
        $this->assertNotNull($this->message->getTimestamp());
    }

    public function testGetArguments()
    {
        if(is_null($this->message->getArguments())){
            $this->assertNull($this->message->getArguments());
        } else {
            $this->assertNotNull($this->message->getArguments());
        }
    }
}