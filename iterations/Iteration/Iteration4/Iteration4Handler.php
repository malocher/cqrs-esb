<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Iteration\Iteration4;

use Malocher\Cqrs\Adapter\AdapterTrait;

/**
 * Class Iteration4Handler
 *
 * This Handler class makes use of annotations
 * Note the use of the AdapterTrait which loosely couples this file with the cqrs package
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Iteration\Iteration4
 */
class Iteration4Handler
{
    use AdapterTrait;

    /**
     * @command Iteration\Iteration4\Iteration4Command
     * @param Iteration4Command $command
     */
    public function editCommand(Iteration4Command $command)
    {
        $command->edit();
        print sprintf("%s says: %s ... Command\n", __METHOD__, $command->getPayload());
        $event = new Iteration4Event('Welcome');
        $event->edit();
        $this->getBus()->publishEvent($event);
    }

    /**
     * @event Iteration\Iteration4\Iteration4Event
     * @param Iteration4Event $event
     */
    public function editEvent(Iteration4Event $event)
    {
        print sprintf("%s says: %s ... Event\n", __METHOD__, $event->getPayload());
    }
}
