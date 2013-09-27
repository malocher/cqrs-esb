<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Mock\Command;

use Cqrs\Adapter\AdapterTrait;
use Cqrs\Command\CommandInterface;

class MockCallbackCommandHandler
{
    use AdapterTrait;

    public function handleCommand(CommandInterface $command)
    {
        if ($command instanceof MockCommand) {
            $command->edit();
        }
    }

    /**
     * @Cqrs\Annotation\Command("Test\Coverage\Mock\Command\MockCommand")
     */
    public function handleAnnotationCommand(CommandInterface $command)
    {
        if (is_callable($command->callback)) {
            $command->edit();
            call_user_func($command->callback,$command->isEdited());
        }
    }

}
