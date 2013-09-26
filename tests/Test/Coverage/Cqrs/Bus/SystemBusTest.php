<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Cqrs\Bus;

use Cqrs\Command\CommandInterface;
use Cqrs\Event\EventInterface;

class SystemBusTest extends AbstractBusTest
{
    public function testGetName()
    {
    }

    /*public function testInvokeCommand(CommandInterface $command)
    {

    }

    public function testPublishEvent(EventInterface $event)
    {
    }*/
}