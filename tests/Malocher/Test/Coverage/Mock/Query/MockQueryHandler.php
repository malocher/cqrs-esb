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
 * Class MockQueryHandler
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Malocher\Test\Coverage\Mock\Query
 */
class MockQueryHandler
{
    use AdapterTrait;

    /**
     * @param QueryInterface $query
     * @return array
     */
    public function handleQuery(QueryInterface $query)
    {
        if ($query instanceof MockQuery) {
            $query->edit();
        }
        return array(1, 2, 3, 4, 5);
    }

    /**
     * @param QueryInterface $query
     * @return null
     */
    public function handleQueryWithNoResult(QueryInterface $query)
    {
        if ($query instanceof MockQuery) {
            $query->edit();
        }
        return null;
    }

    /**
     * @query Malocher\Test\Coverage\Mock\Query\MockQuery
     * @param MockQuery $query
     * @return array
     */
    public function handleAnnotationQuery(MockQuery $query)
    {
        if ($query instanceof MockQuery) {
            $query->edit();
        }
        return array(1, 2, 3, 4, 5);
    }

}
