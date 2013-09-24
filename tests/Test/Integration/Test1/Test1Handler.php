<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Integration\Test1;

use Cqrs\Adapter\AdapterTrait;

class Test1Handler
{
    use AdapterTrait;

    public function editCommand(Test1Command $command)
    {
        if ($command instanceof Test1Command) {
            $command->edit();
        }
        if (is_callable($command->callback)) {
            call_user_func($command->callback,$this,$command,$command->isEdited());
        }
    }

    public function editEvent(Test1Event $event)
    {
        if ($event instanceof Test1Event) {
            $event->edit();
        }
        if (is_callable($event->callback)) {
            call_user_func($event->callback,$this,$event,$event->isEdited());
        }
    }
}
