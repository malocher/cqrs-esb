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
use Iteration\Iteration4\Iteration4Bus;
use Iteration\Iteration4\Iteration4Command;

require __DIR__ . '/../bootstrap.php';

/**
 * Class Iteration4
 *
 * This example goes a step further and introduces the system-bus
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Iteration
 */
class Iteration4
{

    /**
     * @var Gate
     */
    private $gate;

    /**
     * @var Iteration4Bus
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
        $this->bus = new Iteration4Bus(
            new ClassMapCommandHandlerLoader(),
            new ClassMapEventListenerLoader()
        );
        $this->gate->attach($this->bus);

        // Use of AnnotationAdapter, adapters always us pipe
        $adapter = new AnnotationAdapter();
        $adapter->pipe($this->bus, array('Iteration\Iteration4\Iteration4Handler'));

        // Enable the SystemBus and pipe it to some Monitoring
        $this->gate->enableSystemBus();
        $adapter->pipe($this->gate->getSystemBus(), array('Iteration\Iteration4\Iteration4Monitor'));

        // Send a command to the bus
        // Iteration4Handler::editCommand is mapped against this command and will be called
        $this->bus->invokeCommand(new Iteration4Command('Hello'));
    }

}


new Iteration4();