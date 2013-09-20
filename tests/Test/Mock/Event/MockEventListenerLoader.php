<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Mock\Event;

use Cqrs\Event\EventListenerLoaderInterface;

class MockEventListenerLoader implements EventListenerLoaderInterface
{
    protected $mockEventListener;
    
    public function setMockEventListener(MockEventListener $mockEventListener) {
        $this->mockEventListener = $mockEventListener;
    }


    public function getEventListener($alias)
    {
        if ($alias == 'mock_event_listener') {
            return $this->mockEventListener;
        }
    }    
}
