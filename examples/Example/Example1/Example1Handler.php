<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Example\Example1;

use Cqrs\Adapter\AdapterTrait;

/**
 * Class Example1Handler
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Example1
 */
class Example1Handler
{
    use AdapterTrait;

    /**
     * @param Example1Command $command
     */
    public function editCommand(Example1Command $command)
    {
        $command->edit();

        print sprintf("%s says: %s ... Command\n"
            ,__METHOD__,$command->getArguments()
        );

        $event = new Example1Event('Hello');
        $event->edit();

        $this->getBus()->publishEvent($event);
    }

    /**
     * @param Example1Event $event
     */
    public function editEvent(Example1Event $event)
    {
        print sprintf("%s says: %s ... Event\n"
            ,__METHOD__,$event->getArguments()
        );
    }
}
