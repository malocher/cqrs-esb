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

/**
 * Simple classmap EventListenerLoader
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class ClassMapEventListenerLoaderTest extends TestCase implements EventListenerLoaderInterfaceTest
{
    public function getEventListener($alias) {
        //return new $alias();
    }
}
