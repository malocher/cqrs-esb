<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Malocher\CqrsTest\Integration\Integration3;

use Malocher\Cqrs\Adapter\AdapterTrait;

/**
 * Class Integration3EventListener
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Malocher\CqrsTest\Integration\Integration3
 */
class Integration3EventListener
{
    use AdapterTrait;

    /**
     * @var null
     */
    protected $Integration3EventMessage = null;

    /**
     * @param Integration3Event $event
     */
    public function onIntegration3(Integration3Event $event)
    {
        $payload = $event->getPayload();
        $this->Integration3EventMessage = $payload['message'];
    }

    /**
     * @return null
     */
    public function getIntegration3EventMessage()
    {
        return $this->Integration3EventMessage;
    }
}
