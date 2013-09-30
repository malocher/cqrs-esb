<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Integration\Test5;

use Cqrs\Adapter\AdapterTrait;
use Cqrs\Message;

/**
 * Class Test5Handler
 * @author Manfred Weber <crafics@php.net>
 * @package Test\Integration\Test5
 */
class Test5Handler
{
    use AdapterTrait;

    /**
     * @command Test\Integration\Test5\Test5Command
     * @param Test5Command $command
     */
    public function editCommand(Test5Command $command)
    {
        if (is_callable($command->callback)) {
            $command->edit();
            call_user_func($command->callback, $command->isEdited());
        }
    }

    /**
     * @event Test\Integration\Test5\Test5Event
     * @param Test5Event $event
     */
    public function editEvent(Test5Event $event)
    {
        if (is_callable($event->callback)) {
            $event->edit();
            call_user_func($event->callback, $event->isEdited());
        }
    }

    /**
     * you should _not_ do this - cqrs definition separates events and commands
     *
     * @event Test\Integration\Test5\Test5Event
     * @command Test\Integration\Test5\Test5Command
     * @param Message $message
     */
    public function editBoth(Message $message)
    {
        if (is_callable($message->callback)) {
            $message->edit();
            call_user_func($message->callback, $message->isEdited());
        }
    }
}
