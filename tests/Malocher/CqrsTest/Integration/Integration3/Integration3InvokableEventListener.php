<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Malocher\CqrsTest\Integration\Integration3;

/**
 * Class Integration3InvokableEventListener
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Malocher\CqrsTest\Integration\Integration3
 */
class Integration3InvokableEventListener
{
    /**
     * @var
     */
    protected $Integration3EventMessage;

    /**
     * @param Integration3Event $event
     */
    public function __invoke(Integration3Event $event)
    {
        $payload = $event->getPayload();
        $this->Integration3EventMessage = $payload['message'];
    }

    /**
     * @return mixed
     */
    public function getIntegration3EventMessage()
    {
        return $this->Integration3EventMessage;
    }
}
