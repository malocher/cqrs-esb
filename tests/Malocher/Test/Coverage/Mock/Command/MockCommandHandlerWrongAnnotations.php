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
use Malocher\Cqrs\Command\CommandInterface;

/**
 * Class MockCommandHandlerWrongAnnotations
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Malocher\Test\Coverage\Mock\Command
 */
class MockCommandHandlerWrongAnnotations
{
    use AdapterTrait;

    /**
     * @command Malocher\Test\Coverage\Mock\Command\NonExistingMockCommand
     * @param CommandInterface $command
     */
    public function handleNonExistingAnnotationCommand(CommandInterface $command)
    {
    }

}
