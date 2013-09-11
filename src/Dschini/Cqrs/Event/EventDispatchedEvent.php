<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dschini\Cqrs\Event;

use Dschini\Cqrs\Event;

/**
 * EventDispatchedEvent
 *
 * @author Manfred Weber <manfred.weber@gmail.com>
 */
class EventDispatchedEvent extends Event {

    const NAME = "eventDispatched";

    public $version = 1.0;

    public function __construct($data, $synchronized=false) {
        parent::__construct(self::NAME,$data,$synchronized);
        $this->data = $data;
    }

}