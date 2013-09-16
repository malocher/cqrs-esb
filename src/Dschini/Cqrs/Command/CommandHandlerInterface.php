<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Dschini\Cqrs\Command;

use Dschini\Cqrs\Gate;

/**
 * Interface for a CommandHandler
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
interface CommandHandlerInterface
{
    /**
     * Handle the provided command
     * 
     * @param CommandInterface $command
     * @param Gate             $gate
     *  
     * @return bool Success
     */
    public function handleCommand(CommandInterface $command, Gate $gate);
}
