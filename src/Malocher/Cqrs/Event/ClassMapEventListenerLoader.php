<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Malocher\Cqrs\Event;

/**
 * Class ClassMapEventListenerLoader
 *
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 * @package Malocher\Cqrs\Event
 */
class ClassMapEventListenerLoader implements EventListenerLoaderInterface
{
    /**
     * @param string $alias
     * @return mixed
     * @throws EventException
     */
    public function getEventListener($alias)
    {
        if (class_exists($alias)) {
            return new $alias;
        }
        throw EventException::listenerError(sprintf('alias <%s> does not exist', $alias));
    }
}
