<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Cqrs\Message;

use Malocher\Cqrs\Message\Message;
use Test\TestCase;
use Test\Coverage\Mock\Message\PayloadMock;

/**
 * Class MessageTest
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Test\Coverage\Cqrs
 */
class MessageTest extends TestCase
{
    /**
     * @var Message $message
     */
    protected $message;

    public function testConstructed()
    {
        $this->message = new Message();
        $this->assertInstanceOf('Malocher\Cqrs\Message\Message', $this->message);
    }

    public function testConstructedWithArrayPayload()
    {
        $this->message = new Message(array(1, 2, 3, 4, 5));
        $this->assertInstanceOf('Malocher\Cqrs\Message\Message', $this->message);
    }
    
    public function testConstructedWithPayloadInterface()
    {
        $payload = new PayloadMock();
        
        $payload->name = 'John Doe';
        
        $this->message = new Message($payload);
        $this->assertInstanceOf('Malocher\Cqrs\Message\Message', $this->message);
        $this->assertEquals(['name' => 'John Doe'], $this->message->getPayload());
    }
    
    public function testFailedConstructWithWrongPayloadType()
    {
        $this->setExpectedException('Malocher\Cqrs\Message\MessageException');
        $wrongPayload = new \stdClass();
        $message = new Message($wrongPayload);
    }

    public function testGetId()
    {
        $this->message = new Message();
        $this->assertNotNull($this->message->getId());
    }

    public function testSetGetId()
    {
        $this->message = new Message(null, 1);

        $this->assertEquals(1, $this->message->getId());
    }

    public function testGetTimestamp()
    {
        $this->message = new Message();
        $this->assertNotNull($this->message->getTimestamp());
    }

    public function testSetGetTimestamp()
    {
        $ts = strtotime('-1 day');

        $this->message = new Message(null, null, $ts);

        $this->assertEquals($ts, $this->message->getTimestamp());
    }

    public function testGetVersion()
    {
        $this->message = new Message();
        $this->assertEquals(1.0, $this->message->getVersion());
    }

    public function testGetAnotherVersion()
    {
        $this->message = new Message(null, null, null, 2.0);
        $this->assertEquals(2.0, $this->message->getVersion());
    }

    public function testGetPayload()
    {
        $this->message = new Message('string payload');
        
        $this->assertEquals('string payload', $this->message->getPayload());
        
        /*
         * This is a realy cool test :-)
        if (is_null($this->message->getArguments())) {
            $this->assertNull($this->message->getArguments());
        } else {
            $this->assertNotNull($this->message->getArguments());
        }
         */
    }
}