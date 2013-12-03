<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Integration\Test1;

use Malocher\Cqrs\Adapter\AdapterTrait;

/**
 * Class Test1Handler
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Test\Integration\Test1
 */
class Test1Handler
{
    use AdapterTrait;

    /**
     * @param Test1Command $command
     */
    public function editCommand(Test1Command $command)
    {
        if ($command instanceof Test1Command) {
            $command->edit();
        }
        if (is_callable($command->callback)) {
            call_user_func($command->callback, $this, $command, $command->isEdited());
        }
    }

    /**
     * @param Test1Event $event
     */
    public function editEvent(Test1Event $event)
    {
        if ($event instanceof Test1Event) {
            $event->edit();
        }
        if (is_callable($event->callback)) {
            call_user_func($event->callback, $this, $event, $event->isEdited());
        }
    }
}
