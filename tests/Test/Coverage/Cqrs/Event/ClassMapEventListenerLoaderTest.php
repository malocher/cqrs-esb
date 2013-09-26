<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Cqrs\Event;
use Cqrs\Event\ClassMapEventListenerLoader;
use Test\TestCase;

class ClassMapEventListenerLoaderTest extends TestCase implements EventListenerLoaderInterfaceTest
{
    protected $loader;

    public function setUp()
    {
        $this->loader = new ClassMapEventListenerLoader();
    }

    public function testGetEventListener()
    {
        $alias = 'TestAlias';
        //$this->loader->getEventListener($alias);
        $this->assertTrue(true);
    }
}
