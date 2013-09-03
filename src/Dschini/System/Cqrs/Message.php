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
 * Message
 *
 * @author Manfred Weber <manfred.weber@gmail.com>
 */
class Message {

    public $id;
    public $ts;
    public $type;

    public function __construct($type){
        $this->id = uniqid();
        $this->ts = date_timestamp_get(date_create());
        $this->type = $type;
    }
}