<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Integration\Test3;

use Cqrs\Adapter\AdapterTrait;
use Cqrs\Command\CommandInterface;

/**
 * Class Test3CommandHandler
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Test\Integration\Test3
 */
class Test3CommandHandler
{
    use AdapterTrait;

    /**
     * @param CommandInterface $command
     */
    public function handleCommand(CommandInterface $command)
    {
        if ($command instanceof Test3Command) {
            $command->edit();
        }
    }
}
