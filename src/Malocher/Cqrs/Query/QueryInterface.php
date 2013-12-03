<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Malocher\Cqrs\Query;

/**
 * Interface QueryInterface
 *
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
interface QueryInterface
{
    /**
     * Get arguments of the query as array
     *
     * @return array List of arguments
     */
    public function getPayload();

    /**
     * Get version of the query
     *
     * @return int Version number
     */
    public function getVersion();

    /**
     * Get id of the query
     * Id is a unique identifier of this command
     *
     * @return string id
     */
    public function getId();

    /**
     * Get timestamp of the query
     *
     * @return string id
     */
    public function getTimestamp();

    /**
     * Get all properties of the query (id, payload, timestamp, ...)
     *
     * @return array
     */
    public function getMessageVars();
}
