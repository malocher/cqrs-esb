<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Cqrs\Adapter;

use Cqrs\Adapter\AnnotationAdapter;
use Test\TestCase;

class AnnotationAdapterTest extends TestCase implements AdapterInterfaceTest {

    public $annotationAdapter;

    public function setUp()
    {
        $this->annotationAdapter = new AnnotationAdapter();
    }
    /*public function __construct(array $configuration = null)
    {
    }*/

    public function testPipe()
    {
        $this->assertTrue(true);
    }

    public function testAllow()
    {
        $this->assertTrue(true);
    }
}