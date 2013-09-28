<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Mock\Command;

use Cqrs\Adapter\AdapterTrait;
use Cqrs\Command\CommandInterface;

/**
 * Class MockCallbackCommandHandler
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Test\Coverage\Mock\Command
 */
class MockCallbackCommandHandler
{
    use AdapterTrait;

    /**
     * @param MockCommand $command
     */
    public function handleCommand(MockCommand $command)
    {
        if ($command instanceof MockCommand) {
            $command->edit();
        }
    }

    /**
     * @Cqrs\Annotation\Command("Test\Coverage\Mock\Command\MockCommand")
     * @param MockCommand $command
     */
    public function handleAnnotationCommand(MockCommand $command)
    {
        if (is_callable($command->callback)) {
            $command->edit();
            call_user_func($command->callback, $command->isEdited());
        }
    }

}
