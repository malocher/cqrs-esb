<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Integration\Test3;

use Cqrs\Adapter\AdapterTrait;

class Test3EventListener
{
    use AdapterTrait;

    protected $test3EventMessage = null;
    
    public function onTest3(Test3Event $event) {
        $arguments = $event->getArguments();
        $this->test3EventMessage = $arguments['message'];
    }
    
    public function getTest3EventMessage() {
        return $this->test3EventMessage;
    }
}
