<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cqrs\Command;

use Cqrs\Message;

/**
 * PublishEventCommand
 *
 * @author Manfred Weber <manfred.weber@gmail.com>
 */
class PublishEventCommand extends Message implements CommandInterface
{
    /**
     * @var name of the invoking class
     */
    protected $class;

    /**
     * set class name
     *
     * @param string $class
     */
    public function setClass($class) {
        $this->class = $class;
    }

    /**
     * get class name
     *
     * @return string $class
     */
    public function getClass() {
        return $this->class;
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