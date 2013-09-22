<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cqrs\Adapter;

/**
 * AdapterException
 *
 * @author Manfred Weber <manfred.weber@gmail.com>
 */
class AdapterException extends \Exception
{
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

}
