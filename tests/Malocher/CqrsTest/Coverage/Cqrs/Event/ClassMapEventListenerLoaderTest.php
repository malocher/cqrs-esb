<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Malocher\CqrsTest\Coverage\Cqrs\Event;

use Malocher\Cqrs\Event\ClassMapEventListenerLoader;
use Malocher\CqrsTest\TestCase;

/**
 * Class ClassMapEventListenerLoaderTest
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Malocher\CqrsTest\Coverage\Cqrs\Event
 */
class ClassMapEventListenerLoaderTest extends TestCase implements EventListenerLoaderInterfaceTest
{
    /**
     * @var ClassMapEventListenerLoader
     */
    protected $loader;

    public function setUp()
    {
        $this->loader = new ClassMapEventListenerLoader();
    }

    public function testConstructed()
    {
        $this->assertInstanceOf('Malocher\Cqrs\Event\ClassMapEventListenerLoader', $this->loader);
    }

    public function testGetExistingEventListener()
    {
        $alias = 'Malocher\CqrsTest\Coverage\Mock\Event\MockEvent';
        $listener = $this->loader->getEventListener($alias);
        $this->assertInstanceOf('Malocher\CqrsTest\Coverage\Mock\Event\MockEvent', $listener);
    }

    public function testGetNonExistingEventListener()
    {
        $this->setExpectedException('Malocher\Cqrs\Event\EventException');
        $alias = 'Malocher\CqrsTest\Coverage\Mock\Event\NotExisting_MockEvent';
        $this->loader->getEventListener($alias);
    }
}
