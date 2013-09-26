<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Cqrs\Adapter;
use Test\Coverage\Cqrs\Command\CommandInterfaceTest;
use Test\Coverage\Cqrs\Event\EventInterfaceTest;
use Test\Coverage\Cqrs\GateTest;

/**
 * AdapterTraitTest
 *
 * @author Manfred Weber <manfred.weber@gmail.com>
 */
trait AdapterTraitTest {

    /**
     * @var $gate Gate
     *
     * A reference to the gate
     */
    private $gate;

    /**
     * Execute command
     *
     * @param $gate Gate
     * @param $commandHandler object
     * @param $method Method the handler method to execute
     * @param $command CommandInterface to pass to the handler method
     */
    public function executeCommand( GateTest $gate, $commandHandler, $method, CommandInterfaceTest $command)
    {
        //$this->gate = $gate;
        //$commandHandler->{$method}($command);
    }

    /**
     * Execute event
     *
     * @param $gate Gate
     * @param $eventListener object
     * @param $method the handler method to execute
     * @param $event EventInterface to pass to the handler method
     */
    public function executeEvent( GateTest $gate, $eventListener, $method, EventInterfaceTest $event)
    {
        //$this->gate = $gate;
        //$eventListener->{$method}($event);
    }

    /**
     * Get Bus
     *
     * @param $name
     * @return \Cqrs\Bus\BusInterface
     */
    private function getBus( $name )
    {
        //return $this->gate->getBus( $name );
    }
}