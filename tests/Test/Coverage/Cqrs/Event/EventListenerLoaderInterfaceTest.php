<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Cqrs\Event;

/**
 * Interface for a EventListenerLoaderTest
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
interface EventListenerLoaderInterfaceTest
{
    /**
     * Take an alias and get/create an instance of EventListenerInterface
     * 
     * @param string $alias
     * @return EventListenerInterface
     */
    public function getEventListener($alias);
}
