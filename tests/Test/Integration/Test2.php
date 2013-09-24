<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Integration;

use Cqrs\Adapter\AnnotationAdapter;
use Test\TestCase;
use Test\Integration\Test2\Test2Bus;
use Test\Integration\Test2\Test2Command;
use Test\Integration\Test2\Test2Handler;

use Cqrs\Gate;
use Cqrs\Event\ClassMapEventListenerLoader;
use Cqrs\Command\ClassMapCommandHandlerLoader;

class Test2 extends TestCase {

    private $gate;
    private $bus;

    protected function setUp()
    {
        $this->gate = Gate::getInstance()->reset();
        $this->bus = new Test2Bus(
            new ClassMapCommandHandlerLoader(),
            new ClassMapEventListenerLoader()
        );
        $annotationAdapter = new AnnotationAdapter();
        $annotationAdapter->allow($this->bus,'Test\Integration\Test2\Test2Handler');
        $this->gate->attach($this->bus);
    }

    public function test1(){
        $command = new Test2Command();
        $command->callback = function(Test2Handler $returnedHandler,Test2Command $returnedCommand, $returnedCommandIsEdited){
            $this->assertInstanceOf('Test\Integration\Test2\Test2Handler',$returnedHandler);
            $this->assertInstanceOf('Test\Integration\Test2\Test2Command',$returnedCommand);
            $this->assertTrue($returnedCommandIsEdited);
            $this->assertTrue(true);
        };
        $this->bus->invokeCommand($command);
    }
}