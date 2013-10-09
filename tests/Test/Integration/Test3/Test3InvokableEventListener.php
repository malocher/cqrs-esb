<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Integration\Test3;

/**
 * Class Test3InvokableEventListener
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Test\Integration\Test3
 */
class Test3InvokableEventListener
{
    /**
     * @var
     */
    protected $test3EventMessage;

    /**
     * @param Test3Event $event
     */
    public function __invoke(Test3Event $event)
    {
        $payload = $event->getPayload();
        $this->test3EventMessage = $payload['message'];
    }

    /**
     * @return mixed
     */
    public function getTest3EventMessage()
    {
        return $this->test3EventMessage;
    }
}
