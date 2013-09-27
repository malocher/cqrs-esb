<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Cqrs\Event;

use Test\TestCase;
use Cqrs\Event\ClassMapEventListenerLoader;

class ClassMapEventListenerLoaderTest extends TestCase implements EventListenerLoaderInterfaceTest
{
    protected $loader;

    public function setUp()
    {
        $this->loader = new ClassMapEventListenerLoader();
    }

    public function testConstructed()
    {
        $this->assertInstanceOf('Cqrs\Event\ClassMapEventListenerLoader',$this->loader);
    }

    public function testGetExistingEventListener()
    {
        $alias = 'Test\Coverage\Mock\Event\MockEvent';
        $listener = $this->loader->getEventListener($alias);
        $this->assertInstanceOf('Test\Coverage\Mock\Event\MockEvent',$listener);
    }

    public function testGetNonExistingEventListener()
    {
        $this->setExpectedException('Cqrs\Event\EventException');
        $alias = 'Test\Coverage\Mock\Event\NotExisting_MockEvent';
        $this->loader->getEventListener($alias);
    }
}
