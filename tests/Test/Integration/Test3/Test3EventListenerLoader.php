<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Integration\Test3;

use Cqrs\Event\EventListenerLoaderInterface;

class Test3EventListenerLoader implements EventListenerLoaderInterface
{
    protected $test3EventListener;
    
    public function setTest3EventListener(Test3EventListener $test3EventListener) {
        $this->test3EventListener = $test3EventListener;
    }


    public function getEventListener($alias)
    {
        if ($alias == 'test3_event_listener') {
            return $this->test3EventListener;
        }
    }    
}
