<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dschini\System\Cqrs;

use Dschini\System\Cqrs\Message;
use Dschini\System\Interfaces\EventInterface;

/**
 * Command
 *
 * @author Manfred Weber <manfred.weber@gmail.com>
 */
class Event extends Message implements EventInterface {

    const TYPE = "event";

    public $name;
    public $synchronized = false;
    public $data;

    public function __construct($name, $data=null, $synchronized=false){
        parent::__construct(self::TYPE);
        $this->name = $name;
        $this->data = $data;
        $this->synchronized = $synchronized;
    }

}