<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Integration\Test4;

use Malocher\Cqrs\Adapter\AdapterTrait;
use Malocher\Cqrs\Command\CommandInterface;

/**
 * Class Test4CommandHandler
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Test\Integration\Test4
 */
class Test4CommandHandler
{
    use AdapterTrait;

    /**
     * @param CommandInterface $command
     */
    public function handleCommand(CommandInterface $command)
    {
        if ($command instanceof Test4Command) {
            $command->edit();
        }
    }
}
