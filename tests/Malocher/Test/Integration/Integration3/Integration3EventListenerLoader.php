<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Malocher\Test\Integration\Integration3;

use Malocher\Cqrs\Event\EventListenerLoaderInterface;

/**
 * Class Integration3EventListenerLoader
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Malocher\Test\Integration\Integration3
 */
class Integration3EventListenerLoader implements EventListenerLoaderInterface
{
    /**
     * @var
     */
    protected $Integration3EventListener;

    /**
     * @param Integration3EventListener $Integration3EventListener
     */
    public function setIntegration3EventListener(Integration3EventListener $Integration3EventListener)
    {
        $this->Integration3EventListener = $Integration3EventListener;
    }

    /**
     * @param string $alias
     * @return mixed|null
     */
    public function getEventListener($alias)
    {
        if ($alias == 'Integration3_event_listener') {
            return $this->Integration3EventListener;
        }

        return null;
    }
}
