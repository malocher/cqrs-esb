<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Example;

use Cqrs\Adapter\AnnotationAdapter;
use Cqrs\Command\ClassMapCommandHandlerLoader;
use Cqrs\Event\ClassMapEventListenerLoader;
use Cqrs\Gate;
use Example\Example3\Example3Bus;
use Example\Example3\Example3Command;

require __DIR__ . '/../bootstrap.php';

/**
 * Class Example3
 *
 * This is a basic example to start learning how cqrs-php works.
 * A gate is created and a bus is attached, a command handler is mapped and a event listener is registered.
 *
 * We make use of the annotation adapter! Have a look into the Example3/Example3Handler.php
 *
 * The Example3Command is invoked on the bus. The Example3Handler editCommand method is called which publishes
 * the Example3Event back to the bus. The Example3Handler editEvent method method is called.
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Example
 */
class Example3
{

    /**
     * @var Gate
     */
    private $gate;

    /**
     * @var Example3Bus
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
        $this->bus = new Example3Bus(
            new ClassMapCommandHandlerLoader(),
            new ClassMapEventListenerLoader()
        );
        $this->gate->attach($this->bus);

        // Use of AnnotationAdapter, adapters always us pipe
        $adapter = new AnnotationAdapter();
        $adapter->pipe($this->bus, array('Example\Example3\Example3Handler'));
        // See how this affects Example3Handler

        // Send a command to the bus
        // Example3Handler::editCommand is mapped against this command and will be called
        $this->bus->invokeCommand(new Example3Command('Hello'));
    }

}


new Example3();