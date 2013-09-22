<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cqrs\Event;

use Cqrs\Event;
use Cqrs\Message;

/**
 * EventPublishedEvent
 *
 * @author Manfred Weber <manfred.weber@gmail.com>
 */
class EventPublishedEvent extends Message implements EventInterface
{
    protected $class;

    public function setClass($class) {
        $this->class = $class;
    }

    public function getClass() {
        return $this->class;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setTimestamp($ts)
    {
        $this->timestamp = $ts;
    }

    public function setArguments($args)
    {
        $this->arguments = $args;
    }
}