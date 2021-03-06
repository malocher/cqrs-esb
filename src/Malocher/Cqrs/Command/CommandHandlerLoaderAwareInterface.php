<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Malocher\Cqrs\Command;

/**
 * Interface CommandHandlerLoaderAwareInterface
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
interface CommandHandlerLoaderAwareInterface
{
    /**
     * @param CommandHandlerLoaderInterface $commandHandlerLoader
     */
    public function setCommandHandlerLoader(CommandHandlerLoaderInterface $commandHandlerLoader);
}
