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
use Iteration\Iteration2\Iteration2Bus;
use Iteration\Iteration2\Iteration2Command;
use Iteration\Iteration2\Iteration2Event;

require __DIR__ . '/../bootstrap.php';

/**
 * Class Iteration2
 *
 * Using closures or anonymous function to handle command and events
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Iteration
 */
class Iteration2
{

    /**
     * @var Gate
     */
    private $gate;

    /**
     * @var Iteration2Bus
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
        $this->bus = new Iteration2Bus(
            new ClassMapCommandHandlerLoader(),
            new ClassMapEventListenerLoader()
        );
        $this->gate->attach($this->bus);

        // Map a command to a handler
        $this->bus->mapCommand(

            'Iteration\Iteration2\Iteration2Command',
            function (Iteration2Command $command) {
                $command->edit();
                print sprintf("%s says: %s ... Command\n", __METHOD__, $command->getArguments());
                $event = new Iteration2Event('Hello');
                $event->edit();
                $this->bus->publishEvent($event);
            }
        );

        // Register a event to a handler
        $this->bus->registerEventListener(

            'Iteration\Iteration2\Iteration2Event',
            function (Iteration2Event $event) {
                $event->edit();
                print sprintf("%s says: %s ... Event\n", __METHOD__, $event->getArguments());
            }
        );

        // Send a command to the bus
        // Iteration1Handler::editCommand is mapped against this command and will be called
        $this->bus->invokeCommand(new Iteration2Command('Hello'));
    }

}


new Iteration2();