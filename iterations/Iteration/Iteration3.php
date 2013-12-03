<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Iteration;

use Malocher\Cqrs\Adapter\AnnotationAdapter;
use Malocher\Cqrs\Command\ClassMapCommandHandlerLoader;
use Malocher\Cqrs\Event\ClassMapEventListenerLoader;
use Malocher\Cqrs\Gate;
use Malocher\Cqrs\Query\ClassMapQueryHandlerLoader;
use Iteration\Iteration3\Iteration3Bus;
use Iteration\Iteration3\Iteration3Command;

require dirname(dirname(__DIR__)) . '/bootstrap.php';

/**
 * Class Iteration3
 *
 * Use the annotation adapter! Also look into the Iteration3/Iteration3Handler.php
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
        $this->bus = new Iteration3Bus();
        
        $this->bus->setCommandHandlerLoader(new ClassMapCommandHandlerLoader());
        $this->bus->setEventListenerLoader(new ClassMapEventListenerLoader());
        $this->bus->setQueryHandlerLoader(new ClassMapQueryHandlerLoader());
        
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