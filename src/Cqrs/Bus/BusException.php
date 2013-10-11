<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cqrs\Bus;

/**
 * Class BusException
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Cqrs\Bus
 */
class BusException extends \Exception
{
    /**
     * Creates a new BusException describing a trait error.
     *
     * @param string $message Exception message
     * @return BusException
     */
    public static function traitError($message)
    {
        return new self('[Trait Error] ' . $message . "\n");
    }

    /**
     * Creates a new BusException describing a default bus error.
     *
     * @param string $message Exception message
     * @return BusException
     */
    public static function defaultBusError($message)
    {
        return new self('[Default Bus Error] ' . $message . "\n");
    }
    
    /**
     * Creates a new BusException describing a bus not exist error.
     *
     * @param string $message Exception message
     * @return BusException
     */
    public static function busNotExistError($message)
    {
        return new self('[Bus Not Exist Error] ' . $message . "\n");
    }
}
