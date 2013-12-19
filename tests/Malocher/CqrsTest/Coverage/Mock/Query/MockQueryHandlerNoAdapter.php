<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Malocher\CqrsTest\Coverage\Mock\Query;

/**
 * Class MockQueryHandlerNoAdapter
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Malocher\CqrsTest\Coverage\Mock\Query
 */
class MockQueryHandlerNoAdapter
{
    /**
     * @param MockQuery $Query
     * @return array
     */
    public function handleQuery(MockQuery $Query)
    {
        if ($Query instanceof MockQuery) {
            $Query->edit();
        }
        return array(1, 2, 3, 4, 5);
    }

    /**
     * @Query Malocher\CqrsTest\Coverage\Mock\Query\MockQuery
     * @param MockQuery $Query
     * @return array
     */
    public function handleAnnotationQuery(MockQuery $Query)
    {
        if ($Query instanceof MockQuery) {
            $Query->edit();
        }
        return array(1, 2, 3, 4, 5);
    }

}
