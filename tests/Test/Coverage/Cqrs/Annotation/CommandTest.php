<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Cqrs\Annotation;

use Cqrs\Annotation\Command;
use Doctrine\Common\Annotations\AnnotationReader;
use Test\TestCase;

/**
 * Class CommandTest
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Test\Coverage\Cqrs\Annotation
 */
class CommandTest extends TestCase
{
    /**
     * @var AnnotationReader
     */
    private $reader;

    public function setUp()
    {
        $this->reader = new AnnotationReader();
    }

    public function testGetClass()
    {
        $reflClass = new \ReflectionClass('Test\Coverage\Mock\Command\MockCommandHandler');
        $reflM = $reflClass->getMethod('handleAnnotationCommand');
        $aCommand = $this->reader->getMethodAnnotation($reflM, 'Cqrs\Annotation\Command');
        $this->assertEquals('Test\Coverage\Mock\Command\MockCommand', $aCommand->getClass());
        $this->assertTrue(class_exists($aCommand->getClass()));
    }

    public function testInvalidArguments()
    {
        $this->setExpectedException('Cqrs\Annotation\AnnotationException');
        new Command(array('wrong'));
    }
}