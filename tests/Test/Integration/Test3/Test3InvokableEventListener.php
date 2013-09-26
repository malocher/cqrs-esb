<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Integration\Test3;

class Test3InvokableEventListener
{
    protected $test3EventMessage;

    public function __invoke(Test3Event $event)
    {
        $arguments = $event->getArguments();
        $this->test3EventMessage = $arguments['message'];
    }
    
    public function getTest3EventMessage() {
        return $this->test3EventMessage;
    }
}
