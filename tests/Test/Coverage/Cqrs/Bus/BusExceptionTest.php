<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Cqrs\Bus;

/**
 * BusException
 *
 * @author Manfred Weber <manfred.weber@gmail.com>
 */
class BusExceptionTest extends \Exception
{
    /**
     * Creates a new BusException describing a trait error.
     *
     * @param string $message Exception message
     * @return BusException
     */
    public static function traitError($message)
    {
        //return new self('[Trait Error] ' . $message . "\n");
    }

}
