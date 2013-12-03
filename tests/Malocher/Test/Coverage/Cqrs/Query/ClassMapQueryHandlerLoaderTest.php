<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Malocher\Test\Coverage\Cqrs\Query;

use Malocher\Cqrs\Query\ClassMapQueryHandlerLoader;
use Malocher\Test\TestCase;

/**
 * Class ClassMapQueryHandlerLoaderTest
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Test\Malocher\Cqrs\Query
 */
class ClassMapQueryHandlerLoaderTest extends TestCase implements QueryHandlerLoaderInterfaceTest
{
    /**
     * @var ClassMapQueryHandlerLoader
     */
    protected $loader;

    public function setUp()
    {
        $this->loader = new ClassMapQueryHandlerLoader();
    }

    public function testConstructed()
    {
        $this->assertInstanceOf('Malocher\Cqrs\Query\ClassMapQueryHandlerLoader', $this->loader);
    }

    public function testGetExistingQueryHandler()
    {
        $alias = 'Malocher\Test\Coverage\Mock\Query\MockQuery';
        $listener = $this->loader->getQueryHandler($alias);
        $this->assertInstanceOf('Malocher\Test\Coverage\Mock\Query\MockQuery', $listener);
    }

    public function testGetNonExistingQueryHandler()
    {
        $this->setExpectedException('Malocher\Cqrs\Query\QueryException');
        $alias = 'Malocher\Test\Coverage\Mock\Query\NotExisting_MockQuery';
        $this->loader->getQueryHandler($alias);
    }
}
