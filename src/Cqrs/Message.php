<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cqrs;

/**
 * Class Message
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Cqrs
 */
class Message
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var void
     */
    protected $timestamp;

    /**
     * @var int
     */
    protected $version;

    /**
     * @var array
     */
    protected $arguments;

    /**
     * Constructor
     * 
     * @param mixed  $arguments
     * @param string $id
     * @param int    $timestamp
     * @param float  $version
     */
    public function __construct($arguments = null, $id = null, $timestamp = null, $version=1.0)
    {
        if (!is_null($arguments)) {
            $this->arguments = $arguments;
        }
        
        if (is_null($id)) {
            $this->id = uniqid();
        } else {
            $this->id = $id;
        }
        
        if (is_null($timestamp)) {
            $this->timestamp = date_timestamp_get(date_create());
        } else {
            $this->timestamp = $timestamp;
        }
        
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @return float
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return mixed
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @return array
     */
    public function getMessageVars()
    {
        return get_object_vars($this);
    }
}