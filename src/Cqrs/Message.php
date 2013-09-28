<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cqrs;

/**
 * Message
 *
 * @author Manfred Weber <manfred.weber@gmail.com>
 */
class Message {

    /**
     * @var string
     */
    protected $id;

    /**
     * @var void
     */
    protected $timestamp;

    /**
     * @var array
     */
    protected $arguments = array();

    /**
     * @param array $arguments
     */
    public function __construct(array $arguments = null)
    {
        if (!is_null($arguments)) {
            $this->arguments = $arguments;
        }
        $this->id = uniqid();
        $this->timestamp = date_timestamp_get(date_create());
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
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }
}