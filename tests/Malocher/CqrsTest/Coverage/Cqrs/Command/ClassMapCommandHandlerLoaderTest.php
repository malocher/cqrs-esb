<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Malocher\CqrsTest\Coverage\Cqrs\Command;

use Malocher\Cqrs\Command\ClassMapCommandHandlerLoader;
use Malocher\CqrsTest\TestCase;

/**
 * Class ClassMapCommandHandlerLoaderTest
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Malocher\CqrsTest\Coverage\Cqrs\Command
 */
class ClassMapCommandHandlerLoaderTest extends TestCase implements CommandHandlerLoaderInterfaceTest
{
    /**
     * @var ClassMapCommandHandlerLoader
     */
    protected $loader;

    public function setUp()
    {
        $this->loader = new ClassMapCommandHandlerLoader();
    }

    public function testConstructed()
    {
        $this->assertInstanceOf('Malocher\Cqrs\Command\ClassMapCommandHandlerLoader', $this->loader);
    }

    public function testGetExistingCommandListener()
    {
        $alias = 'Malocher\CqrsTest\Coverage\Mock\Command\MockCommand';
        $listener = $this->loader->getCommandHandler($alias);
        $this->assertInstanceOf('Malocher\CqrsTest\Coverage\Mock\Command\MockCommand', $listener);
    }

    public function testGetNonExistingCommandListener()
    {
        $this->setExpectedException('Malocher\Cqrs\Command\CommandException');
        $alias = 'Malocher\CqrsTest\Coverage\Mock\Command\NotExisting_MockCommand';
        $this->loader->getCommandHandler($alias);
    }
}
