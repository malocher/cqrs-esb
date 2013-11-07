<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cqrs\Query;

/**
 * Interface QueryHandlerLoaderAwareInterface
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
interface QueryHandlerLoaderAwareInterface
{
    /**
     * @param QueryHandlerLoaderInterface $queryHandlerLoader
     */
    public function setQueryHandlerLoader(QueryHandlerLoaderInterface $queryHandlerLoader);
}
