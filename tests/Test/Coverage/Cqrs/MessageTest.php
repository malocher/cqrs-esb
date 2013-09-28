<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Cqrs;

use Cqrs\Message;
use Test\TestCase;

/**
 * Class MessageTest
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Test\Coverage\Cqrs
 */
class MessageTest extends TestCase
{
    /**
     * @var mixed
     */
    protected $message;

    public function testConstructed()
    {
        $this->message = new Message();
        $this->assertInstanceOf('Cqrs\Message', $this->message);
    }

    public function testConstructedWithArguments()
    {
        $this->message = new Message(array(1, 2, 3, 4, 5));
        $this->assertInstanceOf('Cqrs\Message', $this->message);
    }

    public function testGetId()
    {
        $this->message = new Message();
        $this->assertNotNull($this->message->getId());
    }

    public function testGetTimestamp()
    {
        $this->message = new Message();
        $this->assertNotNull($this->message->getTimestamp());
    }

    public function testGetArguments()
    {
        $this->message = new Message();
        if (is_null($this->message->getArguments())) {
            $this->assertNull($this->message->getArguments());
        } else {
            $this->assertNotNull($this->message->getArguments());
        }
    }
}