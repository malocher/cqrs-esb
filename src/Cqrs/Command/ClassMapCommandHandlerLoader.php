<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cqrs\Command;

/**
 * Simple classmap CommandHandlerLoader
 * 
 * Can be used as default, if command-handler-aliases are passed as full qualified classnames
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class ClassMapCommandHandlerLoader implements CommandHandlerLoaderInterface
{
    /**
     * {@inheritDoc}
     */
    public function getCommandHandler($alias)
    {
        if( class_exists($alias) ){
            return new $alias;
        }
        throw CommandException::handlerError(sprintf('alias <%s> does not exist',$alias));
    }    
}
