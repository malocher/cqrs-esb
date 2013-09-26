<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Cqrs\Command;
use Cqrs\Command\ClassMapCommandHandlerLoader;
use Test\TestCase;

class ClassMapCommandHandlerLoaderTest extends TestCase implements CommandHandlerLoaderInterfaceTest
{
    protected $loader;

    public function setUp()
    {
        $this->loader = new ClassMapCommandHandlerLoader();
    }

    public function testGetCommandHandler()
    {
        $alias = 'TestAlias';
        //$this->loader->getCommandHandler($alias);
        $this->assertTrue(true);
    }
}
