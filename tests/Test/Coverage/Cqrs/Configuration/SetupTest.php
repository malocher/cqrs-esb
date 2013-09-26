<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Cqrs\Configuration;

use Cqrs\Command\CommandHandlerLoaderInterface;
use Cqrs\Configuration\Setup;
use Cqrs\Event\EventListenerLoaderInterface;
use Test\Coverage\Cqrs\GateTest;
use Test\TestCase;

class SetupTest extends TestCase
{
    private $setup;

    public function setUp()
    {
        $this->setup = new Setup();
    }

    public function testSetGate() {
        //$this->setup->setGate($gate);
        $this->assertTrue(true);
    }
    /*
    public function testSetCommandHandlerLoader(CommandHandlerLoaderInterface $commandHandlerLoader) {
    }
    
    public function testGetCommandHandlerLoader() {
    }
    
    public function testSetEventListenerLoader(EventListenerLoaderInterface $eventListenerLoader) {
    }

    public function testGetEventListenerLoader() {
    }

    public function testInitialize(array $configuration) {
    }
    
    protected function testLoadAdapter(array $configuration) {
    }
    
    protected function testLoadBus($busClass) {
    }
    */
}
