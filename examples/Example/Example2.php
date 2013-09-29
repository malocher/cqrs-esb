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
use Example\Example1\Example1Event;
use Example\Example2\Example2Bus;
use Example\Example2\Example2Command;
use Example\Example2\Example2Event;

require __DIR__ . '/../bootstrap.php';

/**
 * Class Example2
 *
 * This is a basic example to start learning how cqrs-php works.
 * A gate is created and a bus is attached, a command handler is mapped and a event listener is registered.
 *
 * This example uses closures or anonymous function to handle command and events
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Example
 */
class Example2
{

    /**
     * @var Gate
     */
    private $gate;

    /**
     * @var Example2Bus
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
        $this->bus = new Example2Bus(
            new ClassMapCommandHandlerLoader(),
            new ClassMapEventListenerLoader()
        );
        $this->gate->attach($this->bus);

        // Map a command to a handler
        $this->bus->mapCommand(

            'Example\Example2\Example2Command',
            function (Example2Command $command) {
                $command->edit();
                print sprintf("%s says: %s ... Command\n", __METHOD__, $command->getArguments());
                $event = new Example1Event('Hello');
                $event->edit();
                $this->bus->publishEvent($event);
            }
        );

        // Register a event to a handler
        $this->bus->registerEventListener(

            'Example\Example2\Example2Event',
            function (Example2Event $event) {
                $event->edit();
                print sprintf("%s says: %s ... Event\n", __METHOD__, $event->getArguments());
            }
        );

        // Send a command to the bus
        // Example1Handler::editCommand is mapped against this command and will be called
        $this->bus->invokeCommand(new Example2Command('Hello'));
    }

}


new Example1();