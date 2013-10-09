<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cqrs\Command;

use Cqrs\Message\Message;

/**
 * Class PublishEventCommand
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Cqrs\Command
 */
class PublishEventCommand extends Message implements CommandInterface
{
    /**
     * @var string name of the bus of the invoking class
     */
    protected $busName;

    /**
     * @var array message vars of the invoking class
     */
    protected $messageVars;

    /**
     * @var string message class of the invoking class
     */
    protected $messageClass;

    /**
     * set class name
     *
     * @param $messageClass
     */
    public function setMessageClass($messageClass)
    {
        $this->messageClass = $messageClass;
    }

    /**
     * get class name
     *
     * @return string $class
     */
    public function getMessageClass()
    {
        return $this->messageClass;
    }

    /**
     * set message vars
     *
     * @param array $args
     */
    public function setMessageVars($args)
    {
        $this->messageVars = $args;
    }

    /**
     * get message vars
     *
     * @return array
     */
    public function getMessageVars()
    {
        return $this->messageVars;
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
}