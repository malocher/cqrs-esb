<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Iteration\Iteration5;

use Cqrs\Adapter\AdapterTrait;

/**
 * Class Iteration5Handler
 *
 * This Handler class makes use of annotations
 * Note the use of the AdapterTrait which loosely couples this file with the cqrs package
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Iteration\Iteration5
 */
class Iteration5Handler
{
    use AdapterTrait;

    /**
     * @command Iteration\Iteration5\Iteration5Command
     * @param Iteration5Command $command
     */
    public function editCommand(Iteration5Command $command)
    {
        $command->edit();
        print sprintf("%s says: %s ... Command\n", __METHOD__, $command->getArguments());
        $event = new Iteration5Event('Welcome');
        $event->edit();
        $this->getBus()->publishEvent($event);
    }

    /**
     * @event Iteration\Iteration5\Iteration5Event
     * @param Iteration5Event $event
     */
    public function editEvent(Iteration5Event $event)
    {
        print sprintf("%s says: %s ... Event\n", __METHOD__, $event->getArguments());
    }
}
