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

    public function testConstructed()
    {
        $this->assertInstanceOf('Cqrs\Command\ClassMapCommandHandlerLoader',$this->loader);
    }

    public function testGetExistingCommandListener()
    {
        $alias = 'Test\Coverage\Mock\Command\MockCommand';
        $listener = $this->loader->getCommandHandler($alias);
        $this->assertInstanceOf('Test\Coverage\Mock\Command\MockCommand',$listener);
    }

    public function testGetNonExistingCommandListener()
    {
        $this->setExpectedException('Cqrs\Command\CommandException');
        $alias = 'Test\Coverage\Mock\Command\NotExisting_MockCommand';
        $this->loader->getCommandHandler($alias);
    }
}
