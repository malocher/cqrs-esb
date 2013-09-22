<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cqrs\Adapter;

use Cqrs\Command\CommandInterface;
use Cqrs\Event\EventInterface;
use Cqrs\Gate;

/**
 * AdapterTrait
 *
 * @author Manfred Weber <manfred.weber@gmail.com>
 */
trait AdapterTrait {

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
     * @param $method Method the handler method to execute
     * @param $command CommandInterface to pass to the handler method
     */
    public function executeCommand( Gate $gate, $method, CommandInterface $command)
    {
        $this->gate = $gate;
        $this->{$method}($command);
    }

    /**
     * Execute event
     *
     * @param $gate Gate
     * @param $method the handler method to execute
     * @param $event EventInterface to pass to the handler method
     */
    public function executeEvent( Gate $gate, $method, EventInterface $event)
    {
        $this->gate = $gate;
        $this->{$method}($event);
    }

    /**
     * Get Bus
     *
     * @param $name
     * @return \Cqrs\Bus\BusInterface
     */
    private function getBus( $name )
    {
        return $this->gate->getBus( $name );
    }
}