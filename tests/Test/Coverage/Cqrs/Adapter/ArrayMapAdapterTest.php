<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Cqrs\Adapter;

use Cqrs\Adapter\ArrayMapAdapter;
use Test\TestCase;

class ArrayMapAdapterTest extends TestCase implements AdapterInterfaceTest
{
    public $arrayMapAdapter;

    public function setUp()
    {
        $this->arrayMapAdapter = new ArrayMapAdapter();
    }

    public function testPipe()
    {
        //$this->arrayMapAdapter->pipe( $bus, $configuration );
    }
    
    public function testIsCommand() {
        //$this->arrayMapAdapter->isCommand( $messageClass );
    }

    public function testIsEvent() {
        //$this->arrayMapAdapter->isEvent( $messageClass );
    }
}
