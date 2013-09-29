<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Iteration;

use Cqrs\Adapter\AnnotationAdapter;
use Cqrs\Command\ClassMapCommandHandlerLoader;
use Cqrs\Event\ClassMapEventListenerLoader;
use Cqrs\Gate;
use Iteration\Iteration3\Iteration3Bus;
use Iteration\Iteration3\Iteration3Command;

require __DIR__ . '/../bootstrap.php';

/**
 * Class Iteration3
 *
 * This is a basic example to start learning how cqrs-php works.
 * A gate is created and a bus is attached, a command handler is mapped and a event listener is registered.
 *
 * We make use of the annotation adapter! Have a look into the Iteration3/Iteration3Handler.php
 *
 * The Iteration3Command is invoked on the bus. The Iteration3Handler editCommand method is called which publishes
 * the Iteration3Event back to the bus. The Iteration3Handler editEvent method method is called.
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Iteration
 */
class Iteration3
{

    /**
     * @var Gate
     */
    private $gate;

    /**
     * @var Iteration3Bus
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
        $this->bus = new Iteration3Bus(
            new ClassMapCommandHandlerLoader(),
            new ClassMapEventListenerLoader()
        );
        $this->gate->attach($this->bus);

        // Use of AnnotationAdapter, adapters always us pipe
        $adapter = new AnnotationAdapter();
        $adapter->pipe($this->bus, array('Iteration\Iteration3\Iteration3Handler'));
        // See how this affects Iteration3Handler

        // Send a command to the bus
        // Iteration3Handler::editCommand is mapped against this command and will be called
        $this->bus->invokeCommand(new Iteration3Command('Hello'));
    }

}


new Iteration3();