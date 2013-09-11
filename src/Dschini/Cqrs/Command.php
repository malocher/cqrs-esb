<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dschini\Cqrs;

use Dschini\Cqrs\Message;
use Dschini\Cqrs\Interfaces\CommandInterface;

/**
 * Command
 *
 * @author Manfred Weber <manfred.weber@gmail.com>
 */
class Command extends Message implements CommandInterface {

    const TYPE = "command";

    public $name;
    public $synchronized = false;
    public $data;

    public function __construct($name, $data, $synchronized=false){
        parent::__construct(self::TYPE);
        $this->name = $name;
        $this->data = $data;
        $this->synchronized = $synchronized;
    }

}