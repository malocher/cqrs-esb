<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Integration\Test2;

use Cqrs\Adapter\AdapterTrait;

/**
 * Class Test2Handler
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Test\Integration\Test2
 */
class Test2Handler
{
    use AdapterTrait;

    /**
     * @Cqrs\Annotation\Command("Test\Integration\Test2\Test2Command")
     * @param Test2Command $command
     */
    public function editCommand(Test2Command $command)
    {
        if ($command instanceof Test2Command) {
            $command->edit();
        }
        if (is_callable($command->callback)) {
            call_user_func($command->callback, $this, $command, $command->isEdited());
        }
    }

    /**
     * @Cqrs\Annotation\Event("Test\Integration\Test2\Test2Event")
     * @param Test2Event $event
     */
    public function editEvent(Test2Event $event)
    {
        if ($event instanceof Test2Event) {
            $event->edit();
        }
        if (is_callable($event->callback)) {
            call_user_func($event->callback, $this, $event, $event->isEdited());
        }
    }
}
