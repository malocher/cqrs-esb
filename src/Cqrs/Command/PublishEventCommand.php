<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cqrs\Command;

use Cqrs\Message;

/**
 * Class PublishEventCommand
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Cqrs\Command
 */
class PublishEventCommand extends Message implements CommandInterface
{
    /**
     * @var string name of the invoking class
     */
    protected $class;

    /**
     * @var string name of the bus of the invoking class
     */
    protected $busName;

    /**
     * set class name
     *
     * @param string $class
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

    /**
     * get class name
     *
     * @return string $class
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * set bus name
     *
     * @param string $busName
     */
    public function setBusName($busName)
    {
        $this->busName = $busName;
    }

    /**
     * get bus name
     *
     * @return string $busName
     */
    public function getBusName()
    {
        return $this->busName;
    }

    /**
     * set id
     *
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * set timestamp
     *
     * @param int $ts
     */
    public function setTimestamp($ts)
    {
        $this->timestamp = $ts;
    }

    /**
     * set arguments
     *
     * @param array $args
     */
    public function setArguments($args)
    {
        $this->arguments = $args;
    }
}