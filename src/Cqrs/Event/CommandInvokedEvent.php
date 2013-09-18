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
 * CommandInvokedEvent
 *
 * @author Manfred Weber <manfred.weber@gmail.com>
 */
class CommandInvokedEvent extends Message implements EventInterface {

}