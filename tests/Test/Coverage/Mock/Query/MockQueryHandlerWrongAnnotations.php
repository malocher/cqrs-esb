<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Mock\Query;

use Cqrs\Adapter\AdapterTrait;
use Cqrs\Query\QueryInterface;

/**
 * Class MockQueryHandlerWrongAnnotations
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Test\Coverage\Mock\Query
 */
class MockQueryHandlerWrongAnnotations
{
    use AdapterTrait;

    /**
     * @Query Test\Coverage\Mock\Query\NonExistingMockQuery
     * @param QueryInterface $Query
     */
    public function handleNonExistingAnnotationQuery(QueryInterface $Query)
    {
    }

}
