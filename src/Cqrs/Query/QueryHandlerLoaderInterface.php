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
 * Interface QueryHandlerLoaderInterface
 *
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
interface QueryHandlerLoaderInterface
{
    /**
     * Take an alias and get/create an QueryHandler
     *
     * @param string $alias
     * @return mixed
     */
    public function getQueryHandler($alias);
}
