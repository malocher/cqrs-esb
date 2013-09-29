<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Example;

use Cqrs\Command\ClassMapCommandHandlerLoader;
use Cqrs\Event\ClassMapEventListenerLoader;
use Cqrs\Gate;
use Example\Example1\Example1Bus;
use Example\Example1\Example1Command;

require __DIR__ . '/../bootstrap.php';

/**
 * Class Example1
 *
 * This is a basic example to start learning how cqrs-php works.
 * A gate is created and a bus is attached, a command handler is mapped and a event listener is registered.
 *
 * The Example1Command is invoked on the bus. The Example1Handler editCommand method is called which publishes
 * the Example1Event back to the bus. The Example1Handler editEvent method method is called.
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Example\Integration
 */
class Example1
{

    /**
     * @var Gate
     */
    private $gate;

    /**
     * @var Example1Bus
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
        $this->bus = new Example1Bus(
            new ClassMapCommandHandlerLoader(),
            new ClassMapEventListenerLoader()
        );
        $this->gate->attach($this->bus);

        // Map a command to a handler
        $this->bus->mapCommand(
            'Example\Example1\Example1Command',
            array(
                'alias' => 'Example\Example1\Example1Handler',
                'method' => 'editCommand'
            )
        );

        // Register a event to a handler
        $this->bus->registerEventListener(
            'Example\Example1\Example1Event',
            array(
                'alias' => 'Example\Example1\Example1Handler',
                'method' => 'editEvent'
            )
        );

        // Send a command to the bus
        // Example1Handler::editCommand is mapped against this command and will be called
        $this->bus->invokeCommand(new Example1Command('Hello'));
    }

}


new Example1();