<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Integration\Test3;

use Cqrs\Event\EventListenerLoaderInterface;

/**
 * Class Test3EventListenerLoader
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Test\Integration\Test3
 */
class Test3EventListenerLoader implements EventListenerLoaderInterface
{
    /**
     * @var
     */
    protected $test3EventListener;

    /**
     * @param Test3EventListener $test3EventListener
     */
    public function setTest3EventListener(Test3EventListener $test3EventListener)
    {
        $this->test3EventListener = $test3EventListener;
    }

    /**
     * @param string $alias
     * @return mixed|null
     */
    public function getEventListener($alias)
    {
        if ($alias == 'test3_event_listener') {
            return $this->test3EventListener;
        }

        return null;
    }
}
