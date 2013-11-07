<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Iteration;

use Cqrs\Command\ClassMapCommandHandlerLoader;
use Cqrs\Event\ClassMapEventListenerLoader;
use Cqrs\Gate;
use Cqrs\Query\ClassMapQueryHandlerLoader;
use Iteration\Iteration1\Iteration1Bus;
use Iteration\Iteration1\Iteration1Command;

require dirname(dirname(__DIR__)) . '/bootstrap.php';

/**
 * Class Iteration1
 *
 * This is a basic example to start learning how cqrs-php works.
 * A gate is created and a bus is attached, a command handler is mapped and a event listener is registered.
 *
 * The Iteration1Command is invoked on the bus. The Iteration1Handler editCommand method is called which publishes
 * the Iteration1Event back to the bus. The Iteration1Handler editEvent method method is called.
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Iteration
 */
class Iteration1
{

    /**
     * @var Gate
     */
    private $gate;

    /**
     * @var Iteration1Bus
     */
    private $bus;

    /**
     *
     */
    public function __construct()
    {
        // The gate manages the bus system
        $this->gate = new Gate();

        // Create a bus and attach it to the gate
        $this->bus = new Iteration1Bus();
        
        $this->bus->setCommandHandlerLoader(new ClassMapCommandHandlerLoader());
        $this->bus->setEventListenerLoader(new ClassMapEventListenerLoader());
        $this->bus->setQueryHandlerLoader(new ClassMapQueryHandlerLoader());
        
        $this->gate->attach($this->bus);

        // Map a command to a handler
        $this->bus->mapCommand(
            'Iteration\Iteration1\Iteration1Command',
            array(
                'alias' => 'Iteration\Iteration1\Iteration1Handler',
                'method' => 'editCommand'
            )
        );

        // Register a event to a handler
        $this->bus->registerEventListener(
            'Iteration\Iteration1\Iteration1Event',
            array(
                'alias' => 'Iteration\Iteration1\Iteration1Handler',
                'method' => 'editEvent'
            )
        );

        // Send a command to the bus
        // Iteration1Handler::editCommand is mapped against this command and will be called
        $this->bus->invokeCommand(new Iteration1Command('Hello'));
    }

}


new Iteration1();