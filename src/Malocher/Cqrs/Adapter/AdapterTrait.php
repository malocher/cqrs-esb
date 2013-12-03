<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Malocher\Cqrs\Adapter;

use Malocher\Cqrs\Bus\AbstractBus;
use Malocher\Cqrs\Command\CommandInterface;
use Malocher\Cqrs\Event\EventInterface;
use Malocher\Cqrs\Query\QueryInterface;

/**
 * Class AdapterTrait
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Malocher\Cqrs\Adapter
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
     * @param $queryHandler
     * @param $method
     * @param QueryInterface $query
     *
     * @return mixed Result of the query
     */
    public function executeQuery(AbstractBus $bus, $queryHandler, $method, QueryInterface $query)
    {
        $this->bus = $bus;
        return $queryHandler->{$method}($query);
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
     * @return AbstractBus|\Malocher\Cqrs\Bus\BusInterface
     */
    public function getBus($name = null)
    {
        return is_null($name)
            ? $this->bus
            : $this->bus->getGate()->getBus($name);
    }

}