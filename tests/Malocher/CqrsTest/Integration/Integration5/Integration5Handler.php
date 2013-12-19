<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Malocher\CqrsTest\Integration\Integration5;

use Malocher\Cqrs\Adapter\AdapterTrait;
use Malocher\Cqrs\Message\Message;

/**
 * Class Integration5Handler
 * @author Manfred Weber <crafics@php.net>
 * @package Malocher\CqrsTest\Integration\Integration5
 */
class Integration5Handler
{
    use AdapterTrait;

    /**
     * @command Malocher\CqrsTest\Integration\Integration5\Integration5Command
     * @param Integration5Command $command
     */
    public function editCommand(Integration5Command $command)
    {
        if (is_callable($command->callback)) {
            $command->edit();
            call_user_func($command->callback, $command->isEdited());
        }
    }

    /**
     * @event Malocher\CqrsTest\Integration\Integration5\Integration5Event
     * @param Integration5Event $event
     */
    public function editEvent(Integration5Event $event)
    {
        if (is_callable($event->callback)) {
            $event->edit();
            call_user_func($event->callback, $event->isEdited());
        }
    }

    /**
     * you should _not_ do this - cqrs definition separates events and commands
     *
     * @event Malocher\CqrsTest\Integration\Integration5\Integration5Event
     * @command Malocher\CqrsTest\Integration\Integration5\Integration5Command
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
