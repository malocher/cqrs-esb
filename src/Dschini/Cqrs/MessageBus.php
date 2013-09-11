<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dschini\Cqrs;

use Dschini\Cqrs\Command;
use Dschini\Cqrs\Event;
use Dschini\Cqrs\Event\CommandInvokedEvent;
use Dschini\Cqrs\Event\EventDispatchedEvent;
use Dschini\Cqrs\Interfaces\ServiceInterface;

/**
 * MessageBus
 *
 * @author Manfred Weber <manfred.weber@gmail.com>
 */
class MessageBus extends Bus {

    public function mapCommand(ServiceInterface $service,$commandName){
        $service->subscribe($this);
        array_push($this->commandListener,array('method'=>$commandName,'service'=>$service));
    }

    public function invokeCommand(Command $command){
        $command->bus = $this->name;
        $this->dispatchEvent(new CommandInvokedEvent($command));
        foreach($this->commandListener as $commandListener){
            if($commandListener['method']===$command->name){
                $commandListener['service']->$commandListener['method']($command);
            }
        }
    }

    public function registerEventListener($eventName,$listenerMethod){
        array_push($this->eventListener,array('eventName'=>$eventName,'listenerObj'=>$this->gate->getRouting(),'listenerMethod'=>$listenerMethod));
    }

    public function dispatchEvent(Event $event){
        $event->bus = $this->name;
        foreach($this->eventListener as $eventListener){
            if($eventListener['eventName']===$event->name){
                $eventListener['listenerObj']->$eventListener['listenerMethod']($event);
                if($event->name!=CommandInvokedEvent::NAME && $event->name!=EventDispatchedEvent::NAME){
                    $this->dispatchEvent(new EventDispatchedEvent($event));
                }
            }
        }
    }

}