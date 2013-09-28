<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cqrs\Adapter;

use Cqrs\Bus\AbstractBus;
use Cqrs\Command\CommandInterface;
use Cqrs\Event\EventInterface;

/**
 * Class AdapterTrait
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Cqrs\Adapter
 */
trait AdapterTrait
{
    /**
     * @var AbstractBus $bus
     */
    private $bus;

    /**
     * @param AbstractBus $bus
     * @param $commandHandler
     * @param $method
     * @param CommandInterface $command
     */
    public function executeCommand(AbstractBus $bus, $commandHandler, $method, CommandInterface $command)
    {
        $this->bus = $bus;
        $commandHandler->{$method}($command);
    }

    /**
     * @param AbstractBus $bus
     * @param $eventListener
     * @param $method
     * @param EventInterface $event
     */
    public function executeEvent(AbstractBus $bus, $eventListener, $method, EventInterface $event)
    {
        $this->bus = $bus;
        $eventListener->{$method}($event);
    }

    /**
     * @param null $name
     * @return AbstractBus|\Cqrs\Bus\BusInterface
     */
    public function getBus($name=null)
    {
        return is_null($name)
            ? $this->bus
            : $this->bus->getGate()->getBus($name);
    }

}