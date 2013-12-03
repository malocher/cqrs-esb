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
 * Interface EventListenerLoaderInterface
 *
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 * @package Malocher\Cqrs\Event
 */
interface EventListenerLoaderInterface
{
    /**
     * Take an alias and get/create an instance of EventListenerInterface
     *
     * @param string $alias
     * @return mixed
     */
    public function getEventListener($alias);
}
