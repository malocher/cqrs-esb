<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Iteration\Iteration6;

use Cqrs\Adapter\AdapterTrait;

/**
 * Class Iteration6Handler
 *
 * This Handler class makes use of annotations
 * Note the use of the AdapterTrait which loosely couples this file with the cqrs package
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Iteration\Iteration6
 */
class Iteration6Handler
{
    use AdapterTrait;

    /**
     * @command Iteration\Iteration6\Iteration6Command
     * @param Iteration6Command $command
     */
    public function editCommand(Iteration6Command $command)
    {
        $command->edit();
        print sprintf("%s says: %s ... Command\n", __METHOD__, $command->getPayload());
        $event = new Iteration6Event('Welcome');
        $event->edit();
        $this->getBus()->publishEvent($event);
    }

    /**
     * @event Iteration\Iteration6\Iteration6Event
     * @param Iteration6Event $event
     */
    public function editEvent(Iteration6Event $event)
    {
        print sprintf("%s says: %s ... Event\n", __METHOD__, $event->getPayload());
    }

    /**
     * Because of eventual consistency, it is possible that the information that the UI retrieves
     * from the read side is not yet fully consistent with changes that have just been made on the
     * write side (perhaps by another user of the system).
     *
     * This raises the possibility that the command that is sent to update the list of attendees
     * results in an inconsistent change to the write model.
     * For example, someone else could have deleted the order, or already modified the list of attendees.
     *
     * A solution to this problem is to use version numbers in the read model and the commands.
     * Whenever the write model sends details of a change to the read model, it includes the current version
     * number of the aggregate. When the UI queries the read model, it receives the version number and includes
     * it in the command that it sends to the write model.
     *
     * The write model can compare the version number in the command with the current version number
     * of the aggregate and, if they are different, it can raise a concurrency error and reject the change.
     *
     * „Exploring CQRS and Event Sourcing.“
     *
     * @query Iteration\Iteration6\Iteration6Query
     * @param Iteration6Query $query
     * @return string
     */
    public function editQuery(Iteration6Query $query)
    {
        return sprintf("%s says: %s ... Query\n", __METHOD__, $query->getPayload());
    }
}
