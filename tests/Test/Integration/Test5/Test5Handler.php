<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Integration\Test5;

use Cqrs\Adapter\AdapterTrait;
use Cqrs\Message;

/**
 * Test5Handler
 *
 * @author Manfred Weber <manfred.weber@gmail.com>
 */
class Test5Handler
{
    use AdapterTrait;

    /**
     * @Cqrs\Annotation\Command("Test\Integration\Test5\Test5Command")
     */
    public function editCommand(Test5Command $command)
    {
        if (is_callable($command->callback)) {
            $command->edit();
            call_user_func($command->callback,$command->isEdited());
        }
    }

    /**
     * @Cqrs\Annotation\Event("Test\Integration\Test5\Test5Event")
     */
    public function editEvent(Test5Event $event)
    {
        if (is_callable($event->callback)) {
            $event->edit();
            call_user_func($event->callback,$event->isEdited());
        }
    }

    /**
     * you should _not_ do this - cqrs definition separates events and commands
     *
     * @Cqrs\Annotation\Event("Test\Integration\Test5\Test5Event")
     * @Cqrs\Annotation\Command("Test\Integration\Test5\Test5Command")
     */
    public function editBoth(Message $message)
    {
        if (is_callable($message->callback)) {
            $message->edit();
            call_user_func($message->callback,$message->isEdited());
        }
    }
}
