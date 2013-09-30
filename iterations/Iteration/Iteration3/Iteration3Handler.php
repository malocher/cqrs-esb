<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Iteration\Iteration3;

use Cqrs\Adapter\AdapterTrait;

/**
 * Class Iteration3Handler
 *
 * This Handler class makes use of annotations
 * Note the use of the AdapterTrait which loosely couples this file with the cqrs package
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Iteration\Iteration3
 */
class Iteration3Handler
{
    use AdapterTrait;

    /**
     * @command Iteration\Iteration3\Iteration3Command
     * @param Iteration3Command $command
     */
    public function editCommand(Iteration3Command $command)
    {
        $command->edit();
        print sprintf("%s says: %s ... Command\n", __METHOD__, $command->getArguments());
        $event = new Iteration3Event('Hello');
        $event->edit();
        $this->getBus()->publishEvent($event);
    }

    /**
     * @event Iteration\Iteration3\Iteration3Event
     * @param Iteration3Event $event
     */
    public function editEvent(Iteration3Event $event)
    {
        print sprintf("%s says: %s ... Event\n", __METHOD__, $event->getArguments());
    }
}
