<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Malocher\Test\Coverage\Mock\Query;

use Malocher\Cqrs\Adapter\AdapterTrait;
use Malocher\Cqrs\Query\QueryInterface;

/**
 * Class MockQueryHandlerWrongAnnotations
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Malocher\Test\Coverage\Mock\Query
 */
class MockQueryHandlerWrongAnnotations
{
    use AdapterTrait;

    /**
     * @Query Malocher\Test\Coverage\Mock\Query\NonExistingMockQuery
     * @param QueryInterface $Query
     */
    public function handleNonExistingAnnotationQuery(QueryInterface $Query)
    {
    }

}
