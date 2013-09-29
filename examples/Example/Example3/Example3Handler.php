<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Example\Example3;

use Cqrs\Adapter\AdapterTrait;

/**
 * Class Example3Handler
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Example\Example3
 */
class Example3Handler
{
    use AdapterTrait;

    /**
     * @Cqrs\Annotation\Command("Example\Example3\Example3Command")
     * @param Example3Command $command
     */
    public function editCommand(Example3Command $command)
    {
        $command->edit();

        print sprintf("%s says: %s ... Command\n", __METHOD__, $command->getArguments());

        $event = new Example3Event('Hello');
        $event->edit();

        $this->getBus()->publishEvent($event);
    }

    /**
     * @Cqrs\Annotation\Event("Example\Example3\Example3Event")
     * @param Example3Event $event
     */
    public function editEvent(Example3Event $event)
    {
        print sprintf("%s says: %s ... Event\n", __METHOD__, $event->getArguments());
    }
}
