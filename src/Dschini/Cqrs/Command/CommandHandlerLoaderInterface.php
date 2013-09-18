<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Dschini\Cqrs\Command;

/**
 * Interface for a CommandHandlerLoader
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
interface CommandHandlerLoaderInterface
{
    /**
     * Take an alias and get/create an instance of CommandHandlerInterface
     * 
     * @param string $alias Alias that is known by the command handler loader
     * @return CommandHandlerInterface
     */
    public function getCommandHandler($alias);
}
