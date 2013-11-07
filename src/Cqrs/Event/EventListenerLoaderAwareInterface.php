<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cqrs\Event;

/**
 * Interface EventListenerLoaderAwareInterface
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
interface EventListenerLoaderAwareInterface
{
    /**
     * @param EventListenerLoaderInterface $eventListenerLoader
     */
    public function setEventListenerLoader(EventListenerLoaderInterface $eventListenerLoader);
}
