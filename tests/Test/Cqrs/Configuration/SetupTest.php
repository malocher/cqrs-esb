<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cqrs\Configuration;

use Cqrs\Gate;
use Cqrs\Command\ClassMapCommandHandlerLoader;
use Cqrs\Event\ClassMapEventListenerLoader;
use Test\TestCase;

/**
 * Description of SetupTest
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class SetupTest extends TestCase
{
    /**
     *
     * @var Setup
     */
    protected $object;


    protected function setUp() {
        $this->object = new Setup();
        $this->object->setGate(Gate::getInstance());
        $this->object->setCommandHandlerLoader(new ClassMapCommandHandlerLoader());
        $this->object->setEventListenerLoader(new ClassMapEventListenerLoader());
    }
    
    public function testInitialize() {
        $configuration = array(
            'adapter' => 'Cqrs\Adapter\ArrayMapAdapter',
            'buses' => array(
                'Test\Mock\Bus\BusMock' => array(
                    'command_map' => array(
                        'Test\Mock\Command\MockCommand' => array(
                            'alias' => 'Test\Mock\Command\MockCommandHandler',
                            'method' => 'handleCommand'
                        )
                    )
                )
            )
        );
        
        $this->object->initialize($configuration);
        
        $mockCommand = new \Test\Mock\Command\MockCommand();
        
        Gate::getInstance()->getBus('mock-bus')->invokeCommand($mockCommand);
        
        //The MockCommandHandler should call $mockCommand->edit(), otherwise
        //$mockCommand->isEdited() returns false
        $this->assertTrue($mockCommand->isEdited());
    }
}
