<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cqrs\Event;

/**
 * Interface EventInterface
 *
 * @author Manfred Weber <crafics@php.net>
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 * @package Cqrs\Event
 */
interface EventInterface
{

    /**
     * Constructor
     *
     * @param array $arguments
     */
    public function __construct(array $arguments = null);

    /**
     * Get arguments of the command as array
     *
     * @return array List of arguments
     */
    public function getArguments();

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

    /**
     * Get message vars of the event
     *
     * @return array
     */
    public function getMessageVars();

}