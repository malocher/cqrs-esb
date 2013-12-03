<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Malocher\Cqrs\Message;

/**
 * Interface PayloadInterface
 * 
 * If you want to use an object as payload for a message, the object must implement
 * this interface to make sure that the message can get an array copy of the payload.
 * The array copy is required, cause each message in the cqrs system should use an immutable payload.
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
interface PayloadInterface
{
    /**
     * Get an array copy of the payload
     * 
     * @return array
     */
    public function getArrayCopy();
}
