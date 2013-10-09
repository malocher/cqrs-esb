<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cqrs\Message;
/**
 *  MessageException
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class MessageException extends \Exception
{
    /**
     * Creates a new MessageException describing a payload type error.
     *
     * @param string $message Exception message
     * @return MessageException
     */
    public static function payloadTypeError($message)
    {
        return new self('[Payload Type Error] ' . $message . "\n");
    }
}
