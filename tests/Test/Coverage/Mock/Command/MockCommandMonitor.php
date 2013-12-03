<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Mock\Command;

use Malocher\Cqrs\Command\InvokeCommandCommand;
use Malocher\Cqrs\Event\CommandInvokedEvent;
use Malocher\Cqrs\Message\Message;

/**
 * Class MockCommandMonitor
 *
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 * @package Test\Coverage\Mock\Command
 */
class MockCommandMonitor
{
    /**
     * @var array[InvokeCommandCommand]
     */
    protected $invokeCommandCommands = array();

    /**
     *
     * @var array[CommandInvokedEvent]
     */
    protected $commandInvokedEvents = array();


    /**
     * Invoke acts as command handler and event listener on the system bus
     *
     * @param Message $message
     *
     * @return void
     */
    public function __invoke(Message $message)
    {
        if ($message instanceof InvokeCommandCommand) {
            $this->invokeCommandCommands[] = $message;
        } else if ($message instanceof CommandInvokedEvent) {
            $this->commandInvokedEvents[] = $message;
        }

    }

    /**
     * @return array[InvokeCommandCommand]
     */
    public function getInvokeCommandCommands()
    {
        return $this->invokeCommandCommands;
    }

    /**
     *
     * @return array[CommandInvokedEvent]
     */
    public function getCommandInvokedEvents()
    {
        return $this->commandInvokedEvents;
    }
}
