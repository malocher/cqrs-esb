<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Malocher\Test\Coverage\Mock\Command;

use Malocher\Cqrs\Adapter\AdapterTrait;

/**
 * Class MockCallbackCommandHandler
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Malocher\Test\Coverage\Mock\Command
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
     * @command Malocher\Test\Coverage\Mock\Command\MockCommand
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
