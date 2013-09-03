<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dschini\System\Cqrs;

/**
 * Bus
 *
 * @author Manfred Weber <manfred.weber@gmail.com>
 */
class Bus {

    public $name;
    public $gate;

    protected $commandListener;
    protected $eventListener;

    public function __construct($name){
        $this->name = $name;
        $this->commandListener = array();
        $this->eventListener = array();
    }
}