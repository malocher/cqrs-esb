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

class MockCommandHandler
{
    use AdapterTrait;

    public function handleCommand(CommandInterface $command)
    {
        if ($command instanceof MockCommand) {
            $command->edit();
        }
    }  
}
