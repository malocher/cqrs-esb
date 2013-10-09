<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Integration\Test3;

use Cqrs\Adapter\AdapterTrait;

/**
 * Class Test3EventListener
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Test\Integration\Test3
 */
class Test3EventListener
{
    use AdapterTrait;

    /**
     * @var null
     */
    protected $test3EventMessage = null;

    /**
     * @param Test3Event $event
     */
    public function onTest3(Test3Event $event)
    {
        $payload = $event->getPayload();
        $this->test3EventMessage = $payload['message'];
    }

    /**
     * @return null
     */
    public function getTest3EventMessage()
    {
        return $this->test3EventMessage;
    }
}
