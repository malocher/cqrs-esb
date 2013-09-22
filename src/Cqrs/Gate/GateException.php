<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cqrs\Gate;

/**
 * GateException
 *
 * @author Manfred Weber <manfred.weber@gmail.com>
 */
class GateException extends \Exception
{
    /**
     * Creates a new GateException describing a pipe error.
     *
     * @param string $message Exception message
     * @return GateException
     */
    public static function pipeError($message)
    {
        return new self('[Pipe Error] ' . $message);
    }

    /**
     * Creates a new GateException describing a bus error.
     *
     * @param string $message Exception message
     * @return GateException
     */
    public static function busError($message)
    {
        return new self('[Bus Error] ' . $message);
    }

}