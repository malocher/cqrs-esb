<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Cqrs;

use Cqrs\Gate;
use Test\TestCase;

/**
 * Gate
 *
 * @author Manfred Weber <manfred.weber@gmail.com>
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class GateTest extends TestCase {

    private $gate;

    public function setUp()
    {
        $this->gate = Gate::getInstance();
    }

    public function testReset()
    {
        $this->gate->reset();
        //@todo check if bus systems is empty array
        $this->assertTrue(true);
    }

    public function testEnableSystemBus()
    {
        //$this->gate->enableBus();
    }

    public function testDisableSystemBus()
    {
        //$this->gate->disableBus();
    }

    public function testDetach()
    {
        //$this->gate->detach();
    }

    public function testAttach()
    {
        //$this->gate->attach($bus);
    }

    public function testGetBus()
    {
        //$this->gate->getBus($name);
    }

}