<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dschini\Cqrs\Interfaces;

use Dschini\Cqrs\Bus;

/**
 * ServiceInterfaces
 *
 * @author Manfred Weber <manfred.weber@gmail.com>
 */
interface ServiceInterface {

    public function subscribe(Bus $bus);
    public function raise($event);

}