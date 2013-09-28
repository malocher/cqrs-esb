<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Cqrs\Adapter;

use Cqrs\Gate;

/**
 * Class AdapterTraitTest
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Test\Coverage\Cqrs\Adapter
 */
trait AdapterTraitTest
{

    public function testExecuteCommand()
    {
        //$this->bus->executeCommand( $gate, $commandHandler, $method, CommandInterface $command )
    }

    public function testExecuteEvent()
    {
        //$this->bus->executeEvent( new Gate(), 'Test\Coverage\Mock\Event\MockEventHandler', 'handleEvent', new MockCommand() );
    }

    /*private function testGetBus( $name )
    {
    }*/
}