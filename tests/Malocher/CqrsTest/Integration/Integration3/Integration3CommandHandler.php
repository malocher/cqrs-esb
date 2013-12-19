<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Malocher\CqrsTest\Integration\Integration3;

use Malocher\Cqrs\Adapter\AdapterTrait;
use Malocher\Cqrs\Command\CommandInterface;

/**
 * Class Integration3CommandHandler
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Malocher\CqrsTest\Integration\Integration3
 */
class Integration3CommandHandler
{
    use AdapterTrait;

    /**
     * @param CommandInterface $command
     */
    public function handleCommand(CommandInterface $command)
    {
        if ($command instanceof Integration3Command) {
            $command->edit();
        }
    }
}
