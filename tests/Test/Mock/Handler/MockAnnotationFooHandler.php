<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Mock\Handler;

use Cqrs\Adapter\AdapterTrait;
use Cqrs\Annotation\Command;
use Test\Mock\Command\MockCommand;
use Test\Mock\Event\MockEvent;

class MockAnnotationFooHandler {

    use AdapterTrait;

    /**
     * @Cqrs\Annotation\Command("Test\Mock\Command\MockCommand")
     */
    public function getFoo(MockCommand $command)
    {
        var_dump($command);
        $mockEvent = new MockEvent();
        $mockEvent->edit();
        $this->getBus( "mock-annotation-bus" )->publishEvent( $mockEvent );
    }
}