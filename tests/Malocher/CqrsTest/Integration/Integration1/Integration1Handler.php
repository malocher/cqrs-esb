<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Malocher\CqrsTest\Integration\Integration1;

use Malocher\Cqrs\Adapter\AdapterTrait;

/**
 * Class Integration1Handler
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Malocher\CqrsTest\Integration\Integration1
 */
class Integration1Handler
{
    use AdapterTrait;

    /**
     * @param Integration1Command $command
     */
    public function editCommand(Integration1Command $command)
    {
        if ($command instanceof Integration1Command) {
            $command->edit();
        }
        if (is_callable($command->callback)) {
            call_user_func($command->callback, $this, $command, $command->isEdited());
        }
    }

    /**
     * @param Integration1Event $event
     */
    public function editEvent(Integration1Event $event)
    {
        if ($event instanceof Integration1Event) {
            $event->edit();
        }
        if (is_callable($event->callback)) {
            call_user_func($event->callback, $this, $event, $event->isEdited());
        }
    }
}
