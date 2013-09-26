<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Cqrs\Command;
use Test\TestCase;

/**
 * Simple classmap CommandHandlerLoaderTest
 * 
 * Can be used as default, if command-handler-aliases are passed as full qualified classnames
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class ClassMapCommandHandlerLoaderTest extends TestCase implements CommandHandlerLoaderInterfaceTest
{
    /**
     * {@inheritDoc}
     */
    public function getCommandHandler($alias)
    {
        //return new $alias();
    }    
}
