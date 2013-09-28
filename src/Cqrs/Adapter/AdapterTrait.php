<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cqrs\Adapter;

use Cqrs\Command\CommandInterface;
use Cqrs\Event\EventInterface;
use Cqrs\Gate;

/**
 * Class AdapterTrait
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Cqrs\Adapter
 */
trait AdapterTrait
{
    /**
     * @var $gate Gate
     */
    private $gate;

    /**
     * @param Gate $gate
     * @param $commandHandler
     * @param $method callable the handler method to execute
     * @param CommandInterface $command to pass to the handler method
     */
    public function executeCommand(Gate $gate, $commandHandler, $method, CommandInterface $command)
    {
        $this->gate = $gate;
        $commandHandler->{$method}($command);
    }

    /**
     * @param $gate Gate
     * @param $eventListener object
     * @param $method callable the handler method to execute
     * @param $event EventInterface to pass to the handler method
     */
    public function executeEvent(Gate $gate, $eventListener, $method, EventInterface $event)
    {
        $this->gate = $gate;
        $eventListener->{$method}($event);
    }
}