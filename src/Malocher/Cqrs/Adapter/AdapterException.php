<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Malocher\Cqrs\Adapter;

/**
 * Class AdapterException
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Malocher\Cqrs\Adapter
 */
class AdapterException extends \Exception
{
    /**
     * Creates a new AdapterException describing a initialize error.
     *
     * @param string $message Exception message
     * @return AdapterException
     */
    public static function initializeError($message)
    {
        return new self('[Initialize Error] ' . $message . "\n");
    }

    /**
     * Creates a new AdapterException describing a annotation error.
     *
     * @param string $message Exception message
     * @return AdapterException
     */
    public static function annotationError($message)
    {
        return new self('[Annotation Error] ' . $message . "\n");
    }

    /**
     * Creates a new AdapterException describing a pipe error.
     *
     * @param string $message Exception message
     * @return AdapterException
     */
    public static function pipeError($message)
    {
        return new self('[Pipe Error] ' . $message . "\n");
    }

}
