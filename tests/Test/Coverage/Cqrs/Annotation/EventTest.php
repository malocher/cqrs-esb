<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Cqrs\Annotation;

use Cqrs\Annotation\Event;
use Doctrine\Common\Annotations\AnnotationReader;
use Test\TestCase;

/**
 * Class EventTest
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Test\Coverage\Cqrs\Annotation
 */
class EventTest extends TestCase
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
        $reflClass = new \ReflectionClass('Test\Coverage\Mock\Event\MockEventHandler');
        $reflM = $reflClass->getMethod('handleAnnotationEvent');
        $aEvent = $this->reader->getMethodAnnotation($reflM, 'Cqrs\Annotation\Event');
        $this->assertEquals('Test\Coverage\Mock\Event\MockEvent', $aEvent->getClass());
        $this->assertTrue(class_exists($aEvent->getClass()));
    }

    public function testInvalidArguments()
    {
        $this->setExpectedException('Cqrs\Annotation\AnnotationException');
        new Event(array('wrong'));
    }
}