<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Malocher\Cqrs\Event;

use Malocher\Cqrs\Message\Message;

/**
 * Description of QueryExecutedEvent
 *
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 * @copyright (c) 2013, Alexander Miertsch
 */
class QueryExecutedEvent extends Message implements EventInterface
{
    /**
     * @var string name of the bus of the executing class
     */
    protected $busName;

    /**
     * @var array message vars of the query class
     */
    protected $messageVars;

    /**
     * @var string message class of the query class
     */
    protected $messageClass;

    /**
     *
     * @var mixed result of the query
     */
    protected $result;

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

    /**
     * Set result of the query
     *
     * @param mixed $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    /**
     * Get result of the query
     *
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }
}
