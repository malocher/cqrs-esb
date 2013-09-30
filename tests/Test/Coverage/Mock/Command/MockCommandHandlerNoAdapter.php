<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Mock\Command;

/**
 * Class MockCommandHandlerNoAdapter
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Test\Coverage\Mock\Command
 */
class MockCommandHandlerNoAdapter
{
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
     * @command Test\Coverage\Mock\Command\MockCommand
     * @param MockCommand $command
     */
    public function handleAnnotationCommand(MockCommand $command)
    {
        if ($command instanceof MockCommand) {
            $command->edit();
        }
    }

}
