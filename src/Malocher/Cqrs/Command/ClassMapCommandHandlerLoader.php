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
 * Class ClassMapCommandHandlerLoader
 *
 * Can be used as default, if command-handler-aliases are passed as full qualified classnames
 *
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 * @package Malocher\Cqrs\Command
 */
class ClassMapCommandHandlerLoader implements CommandHandlerLoaderInterface
{
    /**
     * get command handler
     *
     * @param string $alias
     * @throws CommandException
     * @return callable
     */
    public function getCommandHandler($alias)
    {
        if (class_exists($alias)) {
            return new $alias;
        }
        throw CommandException::handlerError(sprintf('alias <%s> does not exist', $alias));
    }
}
