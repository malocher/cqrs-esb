<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cqrs\Command;

/**
 * Interface CommandInterface
 *
 * @author Manfred Weber <crafics@php.net>
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 * @package Cqrs\Command
 */
interface CommandInterface
{

    /**
     * Constructor
     *
     * @param mixed $arguments
     */
    public function __construct($arguments = null);

    /**
     * Get arguments of the command as array
     *
     * @return array List of arguments
     */
    public function getArguments();

    /**
     * Get version of the command
     *
     * @return int Version number
     */
    public function getVersion();

    /**
     * Get id of the command
     * Id is a unique identifier of this command
     *
     * @return string id
     */
    public function getId();

    /**
     * Get timestamp of the command
     *
     * @return string id
     */
    public function getTimestamp();

}