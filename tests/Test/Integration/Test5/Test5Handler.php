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

class Test5Handler
{
    use AdapterTrait;

    /**
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
