<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Malocher\Test\Integration\Integration2;

use Malocher\Cqrs\Adapter\AdapterTrait;

/**
 * Class Integration2Handler
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Malocher\Test\Integration\Integration2
 */
class Integration2Handler
{
    use AdapterTrait;

    /**
     * @command Malocher\Test\Integration\Integration2\Integration2Command
     * @param Integration2Command $command
     */
    public function editCommand(Integration2Command $command)
    {
        if ($command instanceof Integration2Command) {
            $command->edit();
        }
        if (is_callable($command->callback)) {
            call_user_func($command->callback, $this, $command, $command->isEdited());
        }
    }

    /**
     * @event Malocher\Test\Integration\Integration2\Integration2Event
     * @param Integration2Event $event
     */
    public function editEvent(Integration2Event $event)
    {
        if ($event instanceof Integration2Event) {
            $event->edit();
        }
        if (is_callable($event->callback)) {
            call_user_func($event->callback, $this, $event, $event->isEdited());
        }
    }
}
