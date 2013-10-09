<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Iteration\Iteration1;

use Cqrs\Adapter\AdapterTrait;

/**
 * Class Iteration1Handler
 *
 * Note the use of the AdapterTrait which loosely couples this file with the cqrs package
 *
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 * @author Manfred Weber <crafics@php.net>
 * @package Iteration\Iteration1
 */
class Iteration1Handler
{
    use AdapterTrait;

    /**
     * @param Iteration1Command $command
     */
    public function editCommand(Iteration1Command $command)
    {
        $command->edit();
        print sprintf("%s says: %s ... Command\n", __METHOD__, $command->getPayload());
        $event = new Iteration1Event('Hello');
        $event->edit();
        $this->getBus()->publishEvent($event);
    }

    /**
     * @param Iteration1Event $event
     */
    public function editEvent(Iteration1Event $event)
    {
        print sprintf("%s says: %s ... Event\n", __METHOD__, $event->getPayload());
    }
}
