<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cqrs\Query;

/**
 * Class QueryException
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Cqrs\Query
 */
class QueryException extends \Exception
{
    /**
     * Creates a new QueryException describing a handler error.
     *
     * @param string $message Exception message
     * @return QueryException
     */
    public static function handlerError($message)
    {
        return new self('[Handler Error] ' . $message . "\n");
    }

}
