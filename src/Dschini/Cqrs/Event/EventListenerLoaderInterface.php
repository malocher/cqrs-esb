<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Dschini\Cqrs\Event;

/**
 * Interface for a EventListenerLoader
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
interface EventListenerLoaderInterface
{
    /**
     * Take an alias and get/create an instance of EventListenerInterface
     * 
     * @param string $alias
     * @return EventListenerInterface
     */
    public function getEventListener($alias);
}
