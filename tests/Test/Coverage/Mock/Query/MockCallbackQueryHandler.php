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

/**
 * Class MockCallbackQueryHandler
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Test\Coverage\Mock\Query
 */
class MockCallbackQueryHandler
{
    use AdapterTrait;

    /**
     * @param MockQuery $query
     * @return array
     */
    public function handleQuery(MockQuery $query)
    {
        if ($query instanceof MockQuery) {
            $query->edit();
        }
        return array(1, 2, 3, 4, 5);
    }

    /**
     * @query Test\Coverage\Mock\Query\MockQuery
     * @param MockQuery $query
     * @return array
     */
    public function handleAnnotationQuery(MockQuery $query)
    {
        if (is_callable($query->callback)) {
            $query->edit();
            call_user_func($query->callback, $query->isEdited());
        }
        return array(1, 2, 3, 4, 5);
    }

}
