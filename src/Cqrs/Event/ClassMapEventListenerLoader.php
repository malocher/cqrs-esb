<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cqrs\Event;

/**
 * Simple classmap EventListenerLoader
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class ClassMapEventListenerLoader implements EventListenerLoaderInterface
{
    /**
     * Get event listener
     *
     * @param string $alias
     * @return EventListenerInterface
     * @throws EventException
     */
    public function getEventListener($alias) {
        if( class_exists($alias) ){
            return new $alias;
        }
        throw EventException::listenerError(sprintf('alias <%s> does not exist',$alias));
    }
}
